package com.educonnect;

import java.net.URI;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;
import java.time.Duration;

public class ApiService {
    private static final String BASE_URL = "http://127.0.0.1:8000/api";
    private static final HttpClient client = HttpClient.newBuilder()
            .connectTimeout(Duration.ofSeconds(10))
            .build();

    private static String authToken = null;

    public static void setAuthToken(String token) {
        authToken = token;
    }

    public static String sendGet(String endpoint) {
        try {
            HttpRequest.Builder builder = HttpRequest.newBuilder()
                    .uri(URI.create(BASE_URL + endpoint))
                    .GET();

            if (authToken != null) {
                builder.header("Authorization", "Bearer " + authToken);
            }

            HttpResponse<String> response = client.send(builder.build(), HttpResponse.BodyHandlers.ofString());
            return response.body();
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }

    public static String sendPost(String endpoint, String jsonBody) {
        try {
            HttpRequest.Builder builder = HttpRequest.newBuilder()
                    .uri(URI.create(BASE_URL + endpoint))
                    .header("Content-Type", "application/json")
                    .POST(HttpRequest.BodyPublishers.ofString(jsonBody));

            if (authToken != null) {
                builder.header("Authorization", "Bearer " + authToken);
            }

            HttpResponse<String> response = client.send(builder.build(), HttpResponse.BodyHandlers.ofString());
            return response.body();
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }

    // Method for fetching posts from Laravel
    public static String getPosts() {
        return sendGet("/posts");
    }

    // Method for creating a new post
    public static String createPost(String title, String content) {
        String jsonBody = "{\"title\":\"" + title + "\", \"content\":\"" + content + "\"}";
        return sendPost("/posts", jsonBody);
    }

    // Method for fetching quizzes from Laravel
    public static String getQuizzes() {
        return sendGet("/quizzes");
    }
}