package services;

import java.io.IOException;
import java.net.URI;
import java.net.http.*;
import java.time.Duration;

public class ApiClient {

    private static final String BASE_URL = "http://127.0.0.1:8000/api";

    private final HttpClient client;

    public ApiClient() {
        this.client = HttpClient.newBuilder()
                .connectTimeout(Duration.ofSeconds(10))
                .build();
    }

    public String post(String endpoint, String jsonBody) throws IOException, InterruptedException {

        HttpRequest request = HttpRequest.newBuilder()
                .uri(URI.create(BASE_URL + endpoint))
                .header("Content-Type", "application/json")
                .POST(HttpRequest.BodyPublishers.ofString(jsonBody))
                .build();

        HttpResponse<String> response =
                client.send(request, HttpResponse.BodyHandlers.ofString());

        return response.body();
    }

    public String postAuth(String endpoint, String jsonBody, String token)
            throws IOException, InterruptedException {

        HttpRequest request = HttpRequest.newBuilder()
                .uri(URI.create(BASE_URL + endpoint))
                .header("Content-Type", "application/json")
                .header("Authorization", "Bearer " + token)
                .POST(HttpRequest.BodyPublishers.ofString(jsonBody))
                .build();

        HttpResponse<String> response =
                client.send(request, HttpResponse.BodyHandlers.ofString());

        return response.body();
    }
}