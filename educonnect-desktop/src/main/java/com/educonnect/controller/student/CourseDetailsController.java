package com.educonnect.controller.student;

import javafx.fxml.FXML;
import javafx.scene.control.Label;
import javafx.scene.control.ListView;
import javafx.collections.FXCollections;

public class CourseDetailsController {

    @FXML private Label courseTitle;
    @FXML private Label descriptionLabel;

    @FXML private ListView<String> topicsList;
    @FXML private ListView<String> resourcesList;

    @FXML
    public void initialize() {
        loadCourse();
    }

    private void loadCourse() {
        // 🔥 MOCK DATA (later from API)

        courseTitle.setText("CS101 - Introduction to Programming");
        descriptionLabel.setText("Learn programming fundamentals using Java.");

        topicsList.setItems(FXCollections.observableArrayList(
                "Variables & Data Types",
                "Control Structures",
                "OOP Basics"
        ));

        resourcesList.setItems(FXCollections.observableArrayList(
                "Week1.pdf",
                "Week2.pdf",
                "Practice Exercises"
        ));
    }

    @FXML
    private void downloadMaterials() {
        System.out.println("Downloading course materials...");
    }

    @FXML
    private void openForum() {
        System.out.println("Opening course forum...");
    }

    @FXML
    private void startQuiz() {
        System.out.println("Launching quiz...");
    }
}