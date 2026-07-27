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

public class SignupController {

    @FXML private TextField nameField;
    @FXML private TextField emailField;
    @FXML private PasswordField passwordField;
    @FXML private ComboBox<String> roleComboBox;
    @FXML private Button submitButton;

    @FXML
    public void initialize() {
        if (roleComboBox != null) {
            roleComboBox.getItems().addAll("Student", "Lecturer", "Admin");
            roleComboBox.setValue("Student"); // Default selection
        }
    }

    @FXML
    private void handleRegister() {
        String name = nameField.getText();
        String email = emailField.getText();
        String password = passwordField.getText();
        String role = roleComboBox.getValue();

        // Basic validation
        if (name.isEmpty() || email.isEmpty() || password.isEmpty()) {
            System.out.println("Please fill in all credential fields!");
            return;
        }

        try {
            // After entering credentials, transition into onboarding step 1
            Stage stage = (Stage) submitButton.getScene().getWindow();
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/view/onboarding_step1.fxml"));
            Parent root = loader.load();
            stage.setScene(new Scene(root));
            stage.setTitle("EduConnect - Onboarding");
            stage.show();

            System.out.println("Account details captured for role: " + role);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}