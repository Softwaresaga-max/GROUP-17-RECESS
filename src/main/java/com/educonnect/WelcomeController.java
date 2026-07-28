package com.educonnect;

import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.stage.Stage;


public class WelcomeController {


    @FXML
    private Button loginNavButton;


    @FXML
    private Button getStartedNavButton;


    @FXML
    private Button createAccountButton;




    @FXML
    private void handleLogin() {

        try {

            Stage stage =
                    (Stage) loginNavButton.getScene().getWindow();


            FXMLLoader loader =
                    new FXMLLoader(
                            getClass().getResource("/view/login.fxml")
                    );


            Scene scene =
                    new Scene(loader.load());


            stage.setTitle("EduConnect - Login");
            stage.setScene(scene);
            stage.centerOnScreen();


        } catch(Exception e){

            e.printStackTrace();

        }

    }






    // This matches welcome.fxml getStarted button
    @FXML
    private void handleGetStarted() {

        openSignup();

    }






    // This matches welcome.fxml create account button
    @FXML
    private void handleCreateAccount() {

        openSignup();

    }







    private void openSignup(){

        try {


            Stage stage =
                    (Stage) createAccountButton.getScene().getWindow();


            FXMLLoader loader =
                    new FXMLLoader(
                            getClass().getResource("/view/signup.fxml")
                    );


            Scene scene =
                    new Scene(loader.load());


            stage.setTitle("EduConnect - Create Account");

            stage.setScene(scene);

            stage.centerOnScreen();



        } catch(Exception e){

            e.printStackTrace();

        }

    }


}