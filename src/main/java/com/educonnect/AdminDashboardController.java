package com.educonnect;

import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.stage.Stage;

public class AdminDashboardController {

    @FXML
    private Button logoutButton;

    @FXML
    public void initialize() {
        System.out.println("Admin Dashboard initialized successfully.");
    }

    @FXML
    private void handleLogout() {
        try {
            Stage stage = (Stage) logoutButton.getScene().getWindow();
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/view/login.fxml"));
            Scene scene = new Scene(loader.load());
            stage.setTitle("EduConnect - Login");
            stage.setScene(scene);
            stage.centerOnScreen();
        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("Failed to return to login view from Admin Dashboard.");
        }
    }
}