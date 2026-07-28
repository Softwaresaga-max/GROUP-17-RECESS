package com.educonnect;


import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.stage.Stage;


public class OnboardingStep1Controller {


    @FXML
    private Button nextButton;



    @FXML
    public void initialize(){

        // Step 1 loading
        System.out.println("Onboarding Step 1 loaded");

    }





    @FXML
    private void handleNext(){


        try{


            Stage stage =
                    (Stage) nextButton
                            .getScene()
                            .getWindow();



            FXMLLoader loader =
                    new FXMLLoader(
                            getClass()
                                    .getResource("/view/onboarding_step2.fxml")
                    );



            if(loader.getLocation() == null){

                System.out.println(
                        "onboarding_step2.fxml not found"
                );

                return;

            }





            Scene scene =
                    new Scene(
                            loader.load()
                    );



            stage.setTitle(
                    "EduConnect - Onboarding Step 2"
            );


            stage.setScene(scene);

            stage.centerOnScreen();



        }
        catch(Exception e){


            System.out.println(
                    "Failed to open Onboarding Step 2"
            );


            e.printStackTrace();


        }


    }



}