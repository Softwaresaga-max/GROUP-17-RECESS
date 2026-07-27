package com.educonnect;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.stage.Stage;

public class OnboardingStep3Controller {

    @FXML
    private Button backButton;

    @FXML
    private Button finishButton;

    @FXML
    private void handleBack(ActionEvent event) {
        try {
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/view/onboarding_step2.fxml"));
            Parent root = loader.load();
            Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
            stage.setScene(new Scene(root));
            stage.show();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    @FXML
    private void handleFinish() {
        try {
            // Fetch courses from Laravel backend right when onboarding finishes
            String coursesResponse = ApiService.getCourses();
            if (coursesResponse != null) {
                System.out.println("Courses fetched successfully from Laravel after completing onboarding!");
            }

            Stage stage = (Stage) finishButton.getScene().getWindow();
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/view/student_dashboard.fxml"));
            Parent root = loader.load();
            stage.setScene(new Scene(root));
            stage.setTitle("EduConnect - Student Dashboard");
            stage.centerOnScreen();
            stage.show();

            System.out.println("Onboarding completed successfully!");
        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("Failed to load Student Dashboard FXML file. Check path.");
        }
    }
}