package com.educonnect;


import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.stage.Stage;


public class LoginController {


    @FXML
    private TextField emailField;


    @FXML
    private PasswordField passwordField;


    @FXML
    private TextField visiblePasswordField;


    @FXML
    private Button togglePasswordButton;


    @FXML
    private ComboBox<String> roleComboBox;


    @FXML
    private Button actionButton;



    private boolean passwordVisible = false;




    @FXML
    public void initialize(){


        roleComboBox.getItems().addAll(
                "student",
                "lecturer",
                "admin"
        );


        roleComboBox.setValue("student");


    }





    @FXML
    private void handleTogglePassword(){


        passwordVisible = !passwordVisible;



        if(passwordVisible){


            visiblePasswordField.setText(
                    passwordField.getText()
            );


            visiblePasswordField.setVisible(true);
            visiblePasswordField.setManaged(true);


            passwordField.setVisible(false);
            passwordField.setManaged(false);


            togglePasswordButton.setText("Hide");


        }
        else{


            passwordField.setText(
                    visiblePasswordField.getText()
            );


            passwordField.setVisible(true);
            passwordField.setManaged(true);


            visiblePasswordField.setVisible(false);
            visiblePasswordField.setManaged(false);


            togglePasswordButton.setText("Show");


        }


    }







    @FXML
    private void handleLoginButtonAction(){



        String email =
                emailField.getText()
                        .trim();



        String password;



        if(passwordVisible){

            password =
                    visiblePasswordField.getText()
                            .trim();

        }
        else{

            password =
                    passwordField.getText()
                            .trim();

        }






        if(email.isEmpty() || password.isEmpty()){


            System.out.println(
                    "Email and password required"
            );

            return;

        }




        if(!email.contains("@")){


            System.out.println(
                    "Enter a valid email address"
            );

            return;

        }







        String response =
                ApiService.login(
                        email,
                        password
                );




        System.out.println(
                "Laravel Response:"
        );


        System.out.println(response);






        if(response != null &&
                response.contains("token")){


            System.out.println(
                    "Login successful"
            );


            routeUser(response);


        }
        else{


            System.out.println(
                    "Login failed"
            );


        }


    }








    private void routeUser(String response){


        try{


            Stage stage =
                    (Stage)
                            emailField.getScene()
                                    .getWindow();




            String role =
                    extractValue(
                            response,
                            "role"
                    );



            String onboarding =
                    extractValue(
                            response,
                            "onboarding_completed"
                    );





            String page;



            if(role.equalsIgnoreCase("admin")){


                page =
                        "/view/admin_dashboard.fxml";


            }
            else if(role.equalsIgnoreCase("lecturer")){


                page =
                        "/view/lecturer_dashboard.fxml";


            }
            else{


                if(onboarding.equals("true")
                        || onboarding.equals("1")
                        || onboarding.equals("0")==false){


                    page =
                            "/src/main/com.educonnect/student_dashboard.fxml";


                }
                else{


                    page =
                            "/view/onboarding_step1.fxml";


                }


            }






            FXMLLoader loader =
                    new FXMLLoader(
                            getClass()
                                    .getResource(page)
                    );



            Scene scene =
                    new Scene(
                            loader.load()
                    );



            stage.setScene(scene);

            stage.centerOnScreen();



        }
        catch(Exception e){


            System.out.println(
                    "Navigation error"
            );


            e.printStackTrace();


        }



    }








    private String extractValue(
            String json,
            String key
    ){


        try{


            if(key.equals("role")){


                return json.split("\"role\":\"")[1]
                        .split("\"")[0];

            }



            if(key.equals("onboarding_completed")){


                return json.split("\"onboarding_completed\":")[1]
                        .split("}")[0]
                        .replace(",","")
                        .trim();

            }


        }
        catch(Exception e){


            return "";

        }



        return "";

    }








    @FXML
    private void handleCreateAccountButton(){


        try{


            Stage stage =
                    (Stage)
                            emailField.getScene()
                                    .getWindow();



            FXMLLoader loader =
                    new FXMLLoader(
                            getClass()
                                    .getResource("/view/register.fxml")
                    );



            Scene scene =
                    new Scene(
                            loader.load()
                    );



            stage.setTitle(
                    "EduConnect - Create Account"
            );


            stage.setScene(scene);

            stage.centerOnScreen();



        }
        catch(Exception e){


            e.printStackTrace();


        }


    }


}