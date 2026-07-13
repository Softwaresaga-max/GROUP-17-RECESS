package com.educonnect.controller.lecturer;

import javafx.fxml.FXML;
import javafx.scene.control.*;

public class MarksEntryController {

    @FXML private TableView<?> marksTable;

    @FXML
    public void initialize() {
        System.out.println("Marks system ready");
    }

    @FXML
    private void saveMarks() {
        System.out.println("Saving marks to API...");
    }
}