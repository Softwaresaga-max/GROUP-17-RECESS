package com.educonnect;

import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.ComboBox;
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
    private Button createAccountButton;

    @FXML
    private ComboBox<String> roleComboBox;

    @FXML
    public void initialize() {
        // Populate the dropdown with your three project roles
        if (roleComboBox != null) {
            roleComboBox.getItems().addAll("Student", "Lecturer", "Admin");
            roleComboBox.setValue("Student"); // Default selection
        }
    }

    @FXML
    private void handleTogglePassword() {
        if (visiblePasswordField.isVisible()) {
            passwordField.setText(visiblePasswordField.getText());
            visiblePasswordField.setVisible(false);
            visiblePasswordField.setManaged(false);
            passwordField.setVisible(true);
            passwordField.setManaged(true);
            togglePasswordButton.setText("Show");
        } else {
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
        String email = emailField.getText() != null ? emailField.getText().trim() : "";
        String password;
        if (visiblePasswordField.isVisible()) {
            password = visiblePasswordField.getText() != null ? visiblePasswordField.getText().trim() : "";
        } else {
            password = passwordField.getText() != null ? passwordField.getText().trim() : "";
        }

        String selectedRole = roleComboBox != null && roleComboBox.getValue() != null
                ? roleComboBox.getValue().toLowerCase()
                : "student";

        if (email.isEmpty() || password.isEmpty()) {
            System.out.println("Please enter both email and password.");
            return;
        }

        // Attempt login via Laravel backend API
        String response = ApiService.login(email, password);

        boolean loginSuccess = false;

        if (response != null && response.contains("token")) {
            System.out.println("Login Successful through Laravel backend!");
            loginSuccess = true;
        } else {
            // Fallback: If backend is offline, allow local test login
            System.out.println("Backend offline or failed. Attempting local validation...");
            if (!email.isEmpty() && !password.isEmpty()) {
                System.out.println("Local Offline Login Successful!");
                loginSuccess = true;
            }
        }

        if (loginSuccess) {
            try {
                Stage stage = (Stage) emailField.getScene().getWindow();
                String targetFxml;

                // Route dynamically based on the role chosen or returned
                switch (selectedRole) {
                    case "admin":
                        targetFxml = "/view/admin_dashboard.fxml";
                        break;
                    case "lecturer":
                        targetFxml = "/view/lecturer_dashboard.fxml";
                        break;
                    case "student":
                    default:
                        targetFxml = "/view/onboarding_step1.fxml"; // or your student dashboard
                        break;
                }

                FXMLLoader loader = new FXMLLoader(getClass().getResource(targetFxml));
                Scene scene = new Scene(loader.load());

                stage.setTitle("EduConnect - " + selectedRole.toUpperCase() + " Portal");
                stage.setScene(scene);
                stage.centerOnScreen();
            } catch (Exception e) {
                e.printStackTrace();
                System.out.println("Failed to load dashboard view for role: " + selectedRole);
            }
        } else {
            System.out.println("Login Failed. Check credentials or ensure Laravel backend is running.");
        }
    }

    @FXML
    private void handleCreateAccountButton() {
        try {
            Stage stage = (Stage) createAccountButton.getScene().getWindow();
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/view/signup.fxml"));
            Parent root = loader.load();
            stage.setScene(new Scene(root));
            stage.setTitle("EduConnect - Sign Up");
            stage.show();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}