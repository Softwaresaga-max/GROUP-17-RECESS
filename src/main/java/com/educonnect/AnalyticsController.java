package com.educonnect;

import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.stage.Stage;

public class AnalyticsController {

    @FXML
    private Button backButton;

    @FXML
    public void initialize() {
        System.out.println("Analytics view initialized successfully.");
        // Fetch analytics metrics from backend if available
    }

    @FXML
    private void handleBack() {
        try {
            Stage stage = (Stage) backButton.getScene().getWindow();
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/view/admin_dashboard.fxml"));
            Scene scene = new Scene(loader.load());
            stage.setTitle("EduConnect - Admin Dashboard");
            stage.setScene(scene);
            stage.centerOnScreen();
        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("Failed to return to Admin Dashboard.");
        }
    }
}