package com.educonnect;

import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.stage.Stage;

public class SignupController {

    @FXML
    private TextField nameField;

    @FXML
    private TextField emailField;

    @FXML
    private PasswordField passwordField;

    @FXML
    private ComboBox<String> roleComboBox;

    @FXML
    private Button submitButton;


    @FXML
    public void initialize() {

        roleComboBox.getItems().addAll(
                "student",
                "lecturer",
                "admin"
        );

        roleComboBox.setValue("student");

    }



    @FXML
    private void handleRegister() {


        String name = nameField.getText().trim();
        String email = emailField.getText().trim();
        String password = passwordField.getText().trim();
        String role = roleComboBox.getValue();



        if(name.isEmpty() || email.isEmpty() || password.isEmpty()){

            System.out.println("Please fill all fields");
            return;

        }



        String response = ApiService.register(
                name,
                email,
                password,
                role
        );


        System.out.println("Laravel Register Response:");
        System.out.println(response);



        if(response != null && response.contains("Account created successfully")){


            System.out.println("Registration successful");


            openOnboarding();


        }
        else{

            System.out.println("Registration failed");

        }


    }



    private void openOnboarding(){

        try{


            Stage stage =
                    (Stage) submitButton.getScene().getWindow();



            FXMLLoader loader =
                    new FXMLLoader(
                            getClass().getResource("/view/onboarding_step1.fxml")
                    );


            Scene scene =
                    new Scene(loader.load());



            stage.setTitle("EduConnect - Onboarding");

            stage.setScene(scene);

            stage.centerOnScreen();



        }
        catch(Exception e){

            e.printStackTrace();

        }

    }

}