package services;

import java.net.http.*;
import java.net.URI;

public class AuthService {

    private String token; // store token in memory

    public boolean login(String email, String password) {

        try {
            HttpClient client = HttpClient.newHttpClient();

            String json = """
            {
                "email": "%s",
                "password": "%s"
            }
            """.formatted(email, password);

            HttpRequest request = HttpRequest.newBuilder()
                    .uri(URI.create("http://127.0.0.1:8000/api/login"))
                    .header("Content-Type", "application/json")
                    .POST(HttpRequest.BodyPublishers.ofString(json))
                    .build();

            HttpResponse<String> response =
                    client.send(request, HttpResponse.BodyHandlers.ofString());

            if (response.statusCode() == 200) {

                String body = response.body();

                // VERY SIMPLE TOKEN EXTRACTION (we improve later with JSON parser)
                if (body.contains("token")) {

                    // extract token manually (temporary)
                    this.token = body;

                    System.out.println("LOGIN SUCCESS");
                    return true;
                }
            }

            return false;

        } catch (Exception e) {
            System.out.println("LOGIN ERROR: " + e.getMessage());
            return false;
        }
    }

    public String getToken() {
        return token;
    }
}