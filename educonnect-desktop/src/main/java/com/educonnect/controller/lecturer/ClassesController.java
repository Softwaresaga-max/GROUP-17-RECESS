package com.educonnect.controller.lecturer;

import javafx.fxml.FXML;
import javafx.scene.control.*;
import javafx.collections.*;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.layout.StackPane;

public class ClassesController {

    @FXML private ListView<String> classList;

    private ObservableList<String> classes = FXCollections.observableArrayList(
            "CS101 - Introduction to Programming",
            "CS201 - Data Structures",
            "CS301 - Software Engineering"
    );

    @FXML
    public void initialize() {
        classList.setItems(classes);

        classList.setOnMouseClicked(event -> {
            if (event.getClickCount() == 2) {
                openClass(classList.getSelectionModel().getSelectedItem());
            }
        });
    }

    private void openClass(String selectedClass) {
        try {
            FXMLLoader loader = new FXMLLoader(
                    getClass().getResource("/modules/lecturer/class-students.fxml")
            );

            Parent view = loader.load();

            ClassStudentsController controller = loader.getController();
            controller.setClass(selectedClass);

            // inject into dashboard content area later
            System.out.println("Opening class: " + selectedClass);

        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}