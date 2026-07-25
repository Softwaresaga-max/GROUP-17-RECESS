package com.educonnect;

import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.stage.Stage;

public class OnboardingStep3Controller {

    @FXML
    private Button backButton;

    @FXML
    private Button finishButton;

    @FXML
    private void handleBack() {
        try {
            Stage stage = (Stage) backButton.getScene().getWindow();
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/view/onboarding_step2.fxml"));
            Scene scene = new Scene(loader.load());
            stage.setTitle("EduConnect - Onboarding Step 2");
            stage.setScene(scene);
            stage.centerOnScreen();
        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("Failed to load Onboarding Step 2.");
        }
    }

    @FXML
    private void handleFinish() {
        try {
            Stage stage = (Stage) finishButton.getScene().getWindow();
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/view/student_dashboard.fxml"));
            Scene scene = new Scene(loader.load());
            stage.setTitle("EduConnect - Student Dashboard");
            stage.setScene(scene);
            stage.centerOnScreen();
        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("Failed to load Student Dashboard view. Make sure student_dashboard.fxml exists.");
        }
    }
}