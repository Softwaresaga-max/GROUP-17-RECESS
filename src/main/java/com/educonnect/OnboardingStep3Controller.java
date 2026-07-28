package com.educonnect;

import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Button;
import javafx.scene.control.CheckBox;
import javafx.stage.Stage;

import java.io.IOException;

public class OnboardingStep3Controller {


    @FXML
    private CheckBox agreeCheckBox;


    @FXML
    private Button finishButton;



    @FXML
    private void handleFinish() {


        // Check if user confirmed information
        if (!agreeCheckBox.isSelected()) {

            showAlert(
                    "Confirmation Required",
                    "Please confirm your information before continuing."
            );

            return;
        }



        try {


            /*
             * Complete onboarding in Laravel
             * These values will later come from
             * Step 1 and Step 2 controllers.
             */

            String registrationCode = "STU-2026-001";

            int classId = 1;



            String response =
                    ApiService.completeOnboarding(
                            registrationCode,
                            classId
                    );



            System.out.println("Onboarding Response:");
            System.out.println(response);



            /*
             * Open Student Dashboard
             *
             * File location should be:
             * src/main/resources/fxml/student_dashboard.fxml
             */

            FXMLLoader loader =
                    new FXMLLoader(
                            getClass()
                                    .getResource(
                                            "/fxml/student_dashboard.fxml"
                                    )
                    );


            Parent root = loader.load();



            Stage stage =
                    (Stage) finishButton
                            .getScene()
                            .getWindow();



            Scene scene =
                    new Scene(root);



            stage.setTitle(
                    "EduConnect - Student Dashboard"
            );


            stage.setScene(scene);


            stage.centerOnScreen();


            stage.show();



        }
        catch (IOException e) {


            System.out.println(
                    "Dashboard loading failed"
            );


            e.printStackTrace();


            showAlert(
                    "Error",
                    "Unable to load student dashboard."
            );


        }
        catch (Exception e) {


            System.out.println(
                    "Failed to complete onboarding"
            );


            e.printStackTrace();


            showAlert(
                    "Error",
                    "Onboarding could not be completed."
            );

        }

    }




    private void showAlert(
            String title,
            String message
    ) {


        Alert alert =
                new Alert(
                        Alert.AlertType.WARNING
                );


        alert.setTitle(title);

        alert.setHeaderText(null);

        alert.setContentText(message);

        alert.showAndWait();

    }


}