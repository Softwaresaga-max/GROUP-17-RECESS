package com.educonnect;

import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.stage.Stage;

import java.io.IOException;

public class LoginController {

    @FXML private TextField usernameField;
    @FXML private PasswordField passwordField;
    @FXML private Label statusLabel;
    @FXML private Button actionButton;
    @FXML private Hyperlink toggleModeLink;

    private boolean isRegisterMode = false;

    @FXML
    public void initialize() {
        // Ensure DB tables exist on launch
        DatabaseHandler.initializeDatabase();
    }

    @FXML
    private void handleAction() {
        String username = usernameField.getText().trim();
        String password = passwordField.getText().trim();

        if (username.isEmpty() || password.isEmpty()) {
            statusLabel.setText("Please enter both username and password.");
            return;
        }

        if (isRegisterMode) {
            // Register standard student account
            if (DatabaseHandler.registerUser(username, password)) {
                statusLabel.setStyle("-fx-text-fill: green;");
                statusLabel.setText("Registration successful! Please log in.");
                toggleMode(); // Switch back to login view
            } else {
                statusLabel.setStyle("-fx-text-fill: red;");
                statusLabel.setText("Username already exists. Try another.");
            }
        } else {
            // Authenticate existing account (Admin or Student)
            if (DatabaseHandler.authenticateUser(username, password)) {
                openDashboard(username);
            } else {
                statusLabel.setStyle("-fx-text-fill: red;");
                statusLabel.setText("Invalid username or password.");
            }
        }
    }

    @FXML
    private void handleToggleMode() {
        toggleMode();
    }

    private void toggleMode() {
        isRegisterMode = !isRegisterMode;
        statusLabel.setText("");

        if (isRegisterMode) {
            actionButton.setText("Register Account");
            toggleModeLink.setText("Already have an account? Log in");
        } else {
            actionButton.setText("Log In");
            toggleModeLink.setText("Need an account? Register");
        }
    }

    private void openDashboard(String username) {
        try {
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/view/dashboard.fxml"));
            Parent root = loader.load();

            DashboardController dashboardController = loader.getController();
            dashboardController.setUsername(username);

            Stage stage = (Stage) usernameField.getScene().getWindow();
            stage.setTitle("EduConnect - Main Dashboard");
            stage.setScene(new Scene(root, 900, 620));
            stage.show();
        } catch (IOException e) {
            e.printStackTrace();
            statusLabel.setText("Failed to load dashboard screen.");
        }
    }
}