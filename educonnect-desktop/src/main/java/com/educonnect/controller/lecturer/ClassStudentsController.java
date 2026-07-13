package com.educonnect.controller.lecturer;

import javafx.fxml.FXML;
import javafx.scene.control.*;
import javafx.collections.*;

public class ClassStudentsController {

    @FXML private Label classTitle;
    @FXML private TableView<?> studentTable;

    private String currentClass;

    public void setClass(String className) {
        this.currentClass = className;
        if (classTitle != null) {
            classTitle.setText(className);
        }
    }

    @FXML
    public void initialize() {
        System.out.println("Loading students...");
    }

    @FXML
    private void openMarksEntry() {
        System.out.println("Opening marks entry for " + currentClass);
    }
}