package com.educonnect.controller.student;

import javafx.fxml.FXML;
import javafx.scene.control.Label;

public class ProfileController {

    @FXML private Label nameLabel;
    @FXML private Label regLabel;
    @FXML private Label courseLabel;
    @FXML private Label yearLabel;
    @FXML private Label gpaLabel;

    @FXML
    public void initialize() {
        loadProfile();
    }

    private void loadProfile() {
        // 🔥 TEMP MOCK (later comes from SessionManager + API)
        nameLabel.setText("Name: John Doe");
        regLabel.setText("Reg No: EDU12345");
        courseLabel.setText("Course: Computer Science");
        yearLabel.setText("Year: 2");
        gpaLabel.setText("GPA: 3.6");
    }

    @FXML
    private void editProfile() {
        System.out.println("Open profile editor...");
    }

    @FXML
    private void openResults() {
        System.out.println("Navigate to results screen...");
    }

    @FXML
    private void openCourses() {
        System.out.println("Navigate to courses screen...");
    }
}