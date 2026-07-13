package com.educonnect.controller;

import com.educonnect.service.ApiService;
import com.educonnect.util.SessionManager;

import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.stage.Stage;

import com.google.gson.JsonObject;
import com.google.gson.JsonParser;


public class LoginController {

    @FXML private TextField emailField;
    @FXML private PasswordField passwordField;
    @FXML private Button loginButton;
    @FXML private ProgressIndicator loadingSpinner;
    @FXML private Label messageLabel;


    @FXML
    private void handleLogin() {

        String email = emailField.getText();
        String password = passwordField.getText();


        if (email == null || email.isBlank()
                || password == null || password.isBlank()) {

            messageLabel.setText("Please enter email and password");
            return;
        }


        try {

            loadingSpinner.setVisible(true);
            messageLabel.setText("");


            String response = ApiService.login(email, password);


            JsonObject obj =
                    JsonParser.parseString(response)
                            .getAsJsonObject();


            loadingSpinner.setVisible(false);


            if (!obj.has("status")
                    || !"success".equals(
                    obj.get("status").getAsString())) {

                messageLabel.setText("Invalid email or password");
                return;
            }


            JsonObject user =
                    obj.getAsJsonObject("user");


            String userId =
                    user.get("id").getAsString();


            String role =
                    user.get("role").getAsString();


            String token =
                    obj.get("token").getAsString();


            // Save token
            ApiService.token = token;


            // Save session
            SessionManager.setSession(
                    userId,
                    role,
                    true
            );


            // Open dashboard
            loadScene("/dashboard.fxml");


        } catch (Exception e) {

            loadingSpinner.setVisible(false);

            messageLabel.setText(
                    "Server error. Try again."
            );

            e.printStackTrace();
        }
    }



    // ---------------- SCENE LOADER ----------------
    private void loadScene(String fxml) throws Exception {


        FXMLLoader loader =
                new FXMLLoader(
                        getClass().getResource(fxml)
                );


        if (loader.getLocation() == null) {

            throw new RuntimeException(
                    "FXML not found: " + fxml
            );
        }


        Parent root = loader.load();


        // FIXED: use emailField instead of loginButton
        Stage stage =
                (Stage) emailField
                        .getScene()
                        .getWindow();


        stage.setScene(
                new Scene(root)
        );


        stage.show();
    }
}