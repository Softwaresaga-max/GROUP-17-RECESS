package com.educonnect.controller.admin;

import com.educonnect.service.ApiService;

import javafx.fxml.FXML;
import javafx.scene.control.*;

public class UserFormController {


    @FXML
    private TextField nameField;

    @FXML
    private TextField emailField;

    @FXML
    private PasswordField passwordField;

    @FXML
    private ComboBox<String> roleBox;

    @FXML
    private Label messageLabel;



    @FXML
    public void initialize() {

        roleBox.getItems().addAll(
                "admin",
                "lecturer",
                "student"
        );

        roleBox.setValue("student");
    }



    // ---------------- SAVE USER ----------------

    @FXML
    private void saveUser() {


        String name =
                nameField.getText();

        String email =
                emailField.getText();

        String password =
                passwordField.getText();

        String role =
                roleBox.getValue();



        if(name.isBlank()
                || email.isBlank()
                || password.isBlank()) {


            messageLabel.setText(
                    "Please fill all fields"
            );

            return;
        }



        boolean success =
                ApiService.createUser(
                        name,
                        email,
                        password,
                        role
                );



        if(success){

            messageLabel.setText(
                    "User created successfully"
            );


            clearFields();


        }else{

            messageLabel.setText(
                    "Failed to create user"
            );

        }

    }




    // ---------------- CLEAR FORM ----------------

    private void clearFields(){

        nameField.clear();

        emailField.clear();

        passwordField.clear();

        roleBox.setValue("student");

    }

}