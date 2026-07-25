package com.educonnect;

import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.PasswordField;
import javafx.scene.control.TextField;
import javafx.stage.Stage;

public class LoginController {

    @FXML
    private TextField emailField;

    @FXML
    private PasswordField passwordField;

    @FXML
    private TextField visiblePasswordField;

    @FXML
    private Button togglePasswordButton;

    @FXML
    private void handleTogglePassword() {
        if (visiblePasswordField.isVisible()) {
            // Hide password, show password field
            passwordField.setText(visiblePasswordField.getText());
            visiblePasswordField.setVisible(false);
            visiblePasswordField.setManaged(false);
            passwordField.setVisible(true);
            passwordField.setManaged(true);
            togglePasswordButton.setText("Show");
        } else {
            // Show password, hide password field
            visiblePasswordField.setText(passwordField.getText());
            passwordField.setVisible(false);
            passwordField.setManaged(false);
            visiblePasswordField.setVisible(true);
            visiblePasswordField.setManaged(true);
            togglePasswordButton.setText("Hide");
        }
    }

    @FXML
    private void handleLoginButtonAction() {
        // Automatically sync text in case they logged in while text was visible
        String username = emailField.getText() != null ? emailField.getText().trim() : "";
        String password;
        if (visiblePasswordField.isVisible()) {
            password = visiblePasswordField.getText() != null ? visiblePasswordField.getText().trim() : "";
        } else {
            password = passwordField.getText() != null ? passwordField.getText().trim() : "";
        }

        if (username.isEmpty() || password.isEmpty()) {
            System.out.println("Please enter both username and password.");
            return;
        }

        // Call the multi-case authentication method from DatabaseHandler
        String role = DatabaseHandler.authenticateAndGetRole(username, password);

        if (role != null) {
            System.out.println("Login Successful! Logged in as role: " + role);

            try {
                Stage stage = (Stage) emailField.getScene().getWindow();

                // Determine which screen to load based on the user's role
                String fxmlFile = "";
                switch (role) {
                    case "ADMIN":
                        fxmlFile = "/view/admin_dashboard.fxml";
                        break;
                    case "LECTURER":
                        fxmlFile = "/view/lecturer_dashboard.fxml";
                        break;
                    case "STUDENT":
                    default:
                        fxmlFile = "/view/onboarding_step1.fxml"; // Starts the student onboarding wizard
                        break;
                }

                FXMLLoader loader = new FXMLLoader(getClass().getResource(fxmlFile));
                Scene scene = new Scene(loader.load());

                stage.setTitle("EduConnect - " + role + " Portal");
                stage.setScene(scene);
                stage.centerOnScreen();
            } catch (Exception e) {
                e.printStackTrace();
                System.out.println("Failed to load dashboard view. Check your FXML file paths.");
            }

        } else {
            System.out.println("Login Failed. Check credentials.");
        }
    }
}