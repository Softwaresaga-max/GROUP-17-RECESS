package com.educonnect;


import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.stage.Stage;



public class OnboardingStep2Controller {



    @FXML
    private TextField nameField;


    @FXML
    private TextField registrationField;


    @FXML
    private TextField courseField;


    @FXML
    private ComboBox<String> yearComboBox;


    @FXML
    private Button nextButton;





    @FXML
    public void initialize(){


        yearComboBox.getItems().addAll(
                "Year 1",
                "Year 2",
                "Year 3",
                "Year 4",
                "Year 5"
        );


    }








    @FXML
    private void handleNext(){



        String name =
                nameField.getText().trim();


        String registration =
                registrationField.getText().trim();


        String course =
                courseField.getText().trim();


        String year =
                yearComboBox.getValue();




        if(name.isEmpty()){

            showMessage("Enter your full name");
            return;

        }



        if(registration.isEmpty()){

            showMessage("Enter registration number");
            return;

        }



        if(course.isEmpty()){

            showMessage("Enter your programme/course");
            return;

        }



        if(year == null){

            showMessage("Select year of study");
            return;

        }





        System.out.println("Name: " + name);
        System.out.println("Registration: " + registration);
        System.out.println("Course: " + course);
        System.out.println("Year: " + year);





        try{


            Stage stage =
                    (Stage)
                            nextButton.getScene()
                                    .getWindow();



            FXMLLoader loader =
                    new FXMLLoader(
                            getClass()
                                    .getResource(
                                            "/view/onboarding_step3.fxml"
                                    )
                    );



            Scene scene =
                    new Scene(
                            loader.load()
                    );



            stage.setTitle(
                    "EduConnect - Onboarding Step 3"
            );


            stage.setScene(scene);

            stage.centerOnScreen();



        }
        catch(Exception e){


            e.printStackTrace();


        }


    }







    private void showMessage(String message){


        Alert alert =
                new Alert(
                        Alert.AlertType.WARNING
                );


        alert.setTitle(
                "Incomplete Information"
        );


        alert.setHeaderText(null);


        alert.setContentText(message);


        alert.showAndWait();


    }



}