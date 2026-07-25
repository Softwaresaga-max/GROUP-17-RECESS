package com.educonnect;

import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.stage.Stage;

public class OnboardingStep2Controller {

    @FXML
    private Button backButton;

    @FXML
    private Button nextButton;

    @FXML
    private void handleBack() {
        try {
            Stage stage = (Stage) backButton.getScene().getWindow();
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/view/onboarding_step1.fxml"));
            Scene scene = new Scene(loader.load());
            stage.setTitle("EduConnect - Onboarding Step 1");
            stage.setScene(scene);
            stage.centerOnScreen();
        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("Failed to load Onboarding Step 1.");
        }
    }

    @FXML
    private void handleNext() {
        try {
            Stage stage = (Stage) nextButton.getScene().getWindow();
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/view/onboarding_step3.fxml"));
            Scene scene = new Scene(loader.load());
            stage.setTitle("EduConnect - Onboarding Step 3");
            stage.setScene(scene);
            stage.centerOnScreen();
        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("Failed to load Onboarding Step 3.");
        }
    }
}