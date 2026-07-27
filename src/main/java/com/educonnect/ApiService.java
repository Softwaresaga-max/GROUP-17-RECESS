package com.educonnect;

import java.net.URI;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;

public class ApiService {
    private static final String BASE_URL = "http://127.0.0.1:8000/api";
    private static final HttpClient client = HttpClient.newHttpClient();

    public static String login(String email, String password) {
        try {
            String jsonInputString = "{\"email\":\"" + email + "\",\"password\":\"" + password + "\"}";

            HttpRequest request = HttpRequest.newBuilder()
                    .uri(URI.create(BASE_URL + "/login"))
                    .header("Content-Type", "application/json")
                    .header("Accept", "application/json")
                    .POST(HttpRequest.BodyPublishers.ofString(jsonInputString))
                    .build();

            HttpResponse<String> response = client.send(request, HttpResponse.BodyHandlers.ofString());
            if (response.statusCode() == 200) {
                return response.body();
            }
        } catch (Exception e) {
            System.err.println("Login API error: " + e.getMessage());
        }
        return null;
    }

    public static String getQuestions(int quizId) {
        return sendGetRequest("/quiz/questions/" + quizId);
    }

    public static String getCourses() {
        return sendGetRequest("/courses");
    }

    public static String getQuizzes() {
        return sendGetRequest("/quizzes");
    }

    // Fetch posts from Laravel backend
    public static String getPosts() {
        return sendGetRequest("/posts");
    }

    // Create post on Laravel backend
    public static boolean createPost(String content) {
        try {
            String jsonPayload = "{\"content\":\"" + content + "\"}";
            HttpRequest request = HttpRequest.newBuilder()
                    .uri(URI.create(BASE_URL + "/posts"))
                    .header("Content-Type", "application/json")
                    .header("Accept", "application/json")
                    .POST(HttpRequest.BodyPublishers.ofString(jsonPayload))
                    .build();
            HttpResponse<String> response = client.send(request, HttpResponse.BodyHandlers.ofString());
            return response.statusCode() == 201 || response.statusCode() == 200;
        } catch (Exception e) {
            System.err.println("Create post API error: " + e.getMessage());
            return false;
        }
    }

    private static String sendGetRequest(String endpoint) {
        try {
            HttpRequest request = HttpRequest.newBuilder()
                    .uri(URI.create(BASE_URL + endpoint))
                    .header("Accept", "application/json")
                    .GET()
                    .build();

            HttpResponse<String> response = client.send(request, HttpResponse.BodyHandlers.ofString());
            if (response.statusCode() == 200) {
                return response.body();
            }
        } catch (Exception e) {
            System.err.println("Backend connection failed for " + endpoint + ": " + e.getMessage());
        }
        return null;
    }
}