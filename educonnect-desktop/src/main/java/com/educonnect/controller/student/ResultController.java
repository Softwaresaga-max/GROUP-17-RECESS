package com.educonnect.controller.student;

import javafx.fxml.FXML;
import javafx.scene.control.*;
import javafx.collections.*;

public class ResultController {

    @FXML private TableView<?> resultsTable;
    @FXML private Label gpaLabel;

    private ObservableList<Object> results = FXCollections.observableArrayList();

    @FXML
    public void initialize() {
        loadResults();
        calculateGPA();
    }

    @FXML
    private void loadResults() {
        System.out.println("Loading student results from API...");

        // TEMP MOCK DATA (replace with Laravel API later)
    }

    private void calculateGPA() {
        // Placeholder logic (real logic comes from backend later)
        double gpa = 3.6;
        gpaLabel.setText("GPA: " + gpa);
    }

    @FXML
    private void viewDetails() {
        System.out.println("Opening course breakdown...");
    }
}