package com.educonnect;

import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.stage.Stage;

public class WelcomeController {

    @FXML
    private Button loginNavButton;

    @FXML
    private Button signInButton;

    @FXML
    private Button getStartedNavButton;

    @FXML
    private Button createAccountButton;

    @FXML
    private void handleLogin() {
        try {
            Stage stage = (Stage) loginNavButton.getScene().getWindow();
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/view/login.fxml"));
            Scene scene = new Scene(loader.load());
            stage.setTitle("EduConnect - Login");
            stage.setScene(scene);
            stage.centerOnScreen();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    @FXML
    private void handleGetStarted() {
        try {
            Stage stage = (Stage) getStartedNavButton.getScene().getWindow();
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/view/onboarding_step1.fxml"));
            Scene scene = new Scene(loader.load());
            stage.setTitle("EduConnect - Onboarding");
            stage.setScene(scene);
            stage.centerOnScreen();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}