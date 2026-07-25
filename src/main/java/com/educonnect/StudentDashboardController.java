package com.educonnect;

import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.stage.Stage;

public class StudentDashboardController {

    @FXML
    private Button logoutButton;

    @FXML
    private void handleLogout() {
        try {
            Stage stage = (Stage) logoutButton.getScene().getWindow();
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/view/welcome.fxml"));
            Scene scene = new Scene(loader.load());
            stage.setTitle("EduConnect - Streamlining Communication");
            stage.setScene(scene);
            stage.centerOnScreen();
        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("Failed to load welcome view. Check your welcome.fxml path.");
        }
    }
}