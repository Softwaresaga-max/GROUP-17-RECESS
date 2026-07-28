package com.educonnect;


import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.stage.Stage;



public class StudentDashboardController {


    @FXML
    private Label welcomeLabel;


    @FXML
    private Button logoutButton;


    @FXML
    private Button announcementButton;


    @FXML
    private Button forumButton;


    @FXML
    private Button quizButton;





    @FXML
    public void initialize(){


        if(ApiService.currentUserName != null &&
                !ApiService.currentUserName.isEmpty()){


            welcomeLabel.setText(
                    "Welcome back, "
                            + ApiService.currentUserName
            );


        }
        else{


            welcomeLabel.setText(
                    "Welcome back to EduConnect"
            );


        }


    }








    // ================= ANNOUNCEMENTS =================


    @FXML
    private void handleAnnouncements(){


        String response =
                ApiService.getPosts();


        System.out.println(
                "Announcements:"
        );


        System.out.println(response);


    }










    // ================= QUIZZES =================


    @FXML
    private void handleQuiz(){


        try{


            FXMLLoader loader =
                    new FXMLLoader(
                            getClass()
                                    .getResource(
                                            "/quizzes.fxml"
                                    )
                    );



            Scene scene =
                    new Scene(
                            loader.load()
                    );



            Stage stage =
                    (Stage)
                            quizButton
                                    .getScene()
                                    .getWindow();



            stage.setTitle(
                    "EduConnect - Quiz Assessment"
            );



            stage.setScene(scene);



            stage.centerOnScreen();



        }
        catch(Exception e){


            System.out.println(
                    "Failed opening quiz page"
            );


            e.printStackTrace();


        }


    }










    // ================= FORUM =================


    @FXML
    private void handleForums(){


        String response =
                ApiService.getPosts();



        System.out.println(
                "Forums:"
        );


        System.out.println(response);



    }










    // ================= LOGOUT =================


    @FXML
    private void handleLogout(){


        ApiService.authToken = "";


        ApiService.currentUserId = 0;


        ApiService.currentUserName = "";


        ApiService.currentUserRole = "";



        try{


            Stage stage =
                    (Stage)
                            logoutButton
                                    .getScene()
                                    .getWindow();



            FXMLLoader loader =
                    new FXMLLoader(
                            getClass()
                                    .getResource(
                                            "/login.fxml"
                                    )
                    );



            Scene scene =
                    new Scene(
                            loader.load()
                    );



            stage.setTitle(
                    "EduConnect Login"
            );


            stage.setScene(scene);



        }
        catch(Exception e){


            e.printStackTrace();


        }



    }


}