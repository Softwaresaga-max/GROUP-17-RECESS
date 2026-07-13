package com.educonnect.controller.admin;


import com.educonnect.model.Student;
import com.educonnect.service.ApiService;

import javafx.fxml.FXML;
import javafx.scene.control.*;
import javafx.beans.property.SimpleStringProperty;
import javafx.collections.*;

import java.util.List;



public class ClassStudentController {


    @FXML
    private TableView<Student> studentTable;


    @FXML
    private TableColumn<Student,String> idCol;


    @FXML
    private TableColumn<Student,String> nameCol;


    @FXML
    private TableColumn<Student,String> emailCol;


    @FXML
    private TableColumn<Student,String> classCol;


    @FXML
    private TableColumn<Student,String> statusCol;



    private ObservableList<Student> students =
            FXCollections.observableArrayList();




    @FXML
    public void initialize(){


        idCol.setCellValueFactory(data ->
                new SimpleStringProperty(
                        data.getValue().getId()
                )
        );


        nameCol.setCellValueFactory(data ->
                new SimpleStringProperty(
                        data.getValue().getName()
                )
        );


        emailCol.setCellValueFactory(data ->
                new SimpleStringProperty(
                        data.getValue().getEmail()
                )
        );


        classCol.setCellValueFactory(data ->
                new SimpleStringProperty(
                        data.getValue().getClassName()
                )
        );


        statusCol.setCellValueFactory(data ->
                new SimpleStringProperty(
                        data.getValue().isActive()
                                ? "Active"
                                : "Inactive"
                )
        );


        loadStudents();

    }




    private void loadStudents(){


        students.clear();


        List<Student> data =
                ApiService.getStudents();



        if(data != null){

            students.addAll(data);

        }


        studentTable.setItems(students);

    }






    // ---------------- ASSIGN STUDENT ----------------


    @FXML
    private void assignStudent(){


        Student selected =
                studentTable.getSelectionModel()
                        .getSelectedItem();



        if(selected == null){

            showMessage(
                    "Please select a student first"
            );

            return;
        }



        TextInputDialog dialog =
                new TextInputDialog();


        dialog.setTitle(
                "Assign Student"
        );


        dialog.setHeaderText(
                "Assign "
                        + selected.getName()
                        + " to class"
        );


        dialog.setContentText(
                "Class ID:"
        );



        dialog.showAndWait()
                .ifPresent(classId -> {



                    boolean success =
                            ApiService.assignStudent(
                                    selected.getId(),
                                    classId
                            );



                    if(success){

                        showMessage(
                                "Student assigned successfully"
                        );

                        loadStudents();

                    }
                    else{

                        showMessage(
                                "Failed to assign student"
                        );

                    }


                });


    }





    // ---------------- REMOVE STUDENT ----------------


    @FXML
    private void removeStudent(){


        Student selected =
                studentTable.getSelectionModel()
                        .getSelectedItem();



        if(selected == null){

            showMessage(
                    "Select student first"
            );

            return;

        }



        showMessage(
                "Remove feature coming next"
        );


    }






    private void showMessage(String message){


        Alert alert =
                new Alert(
                        Alert.AlertType.INFORMATION
                );


        alert.setTitle(
                "EDUCONNECT"
        );


        alert.setHeaderText(null);


        alert.setContentText(
                message
        );


        alert.showAndWait();

    }


}