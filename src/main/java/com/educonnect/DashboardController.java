package com.educonnect;

import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.stage.Stage;

import java.io.IOException;


public class DashboardController {


    @FXML
    private Label welcomeLabel;


    @FXML
    private Button quizButton;


    @FXML
    private Button logoutButton;


    @FXML
    private TextArea postContentArea;


    @FXML
    private ListView<String> postListView;



    private String currentUsername;



    @FXML
    public void initialize(){

        if(ApiService.currentUserName != null &&
                !ApiService.currentUserName.isEmpty()){


            currentUsername =
                    ApiService.currentUserName;


            welcomeLabel.setText(
                    "Welcome, "
                            + currentUsername
            );


        }
        else{

            welcomeLabel.setText(
                    "Welcome to EduConnect"
            );

        }


        loadPosts();

    }






    public void setUsername(String username){

        this.currentUsername = username;

        welcomeLabel.setText(
                "Welcome, "+username
        );

        loadPosts();

    }








    // ================= POSTS =================


    private void loadPosts(){


        String response =
                ApiService.getPosts();


        System.out.println(
                "Posts from Laravel:"
        );


        System.out.println(response);



        if(response != null){

            postListView.getItems().clear();


            postListView.getItems()
                    .add(response);

        }


    }






    @FXML
    private void handlePostSubmit(){


        String content =
                postContentArea.getText();



        if(content.isEmpty()){

            return;

        }



        boolean success =
                ApiService.createPost(content);



        if(success){

            postContentArea.clear();

            loadPosts();

            System.out.println(
                    "Post created successfully"
            );

        }
        else{

            System.out.println(
                    "Failed creating post"
            );

        }


    }









    // ================= QUIZZES =================


    @FXML
    private void handleOpenQuiz(){


        String quizzes =
                ApiService.getQuizzes();


        System.out.println(
                "Available quizzes:"
        );


        System.out.println(quizzes);



        try{


            FXMLLoader loader =
                    new FXMLLoader(
                            getClass()
                                    .getResource(
                                            "/view/quiz.fxml"
                                    )
                    );


            Parent root =
                    loader.load();



            Stage stage =
                    new Stage();



            stage.setTitle(
                    "EduConnect Quiz"
            );


            stage.setScene(
                    new Scene(
                            root
                    )
            );


            stage.show();



        }
        catch(IOException e){

            e.printStackTrace();

        }


    }










    // ================= LOGOUT =================


    @FXML
    private void handleLogout(){


        ApiService.authToken="";


        try{


            FXMLLoader loader =
                    new FXMLLoader(
                            getClass()
                                    .getResource(
                                            "/view/login.fxml"
                                    )
                    );


            Scene scene =
                    new Scene(
                            loader.load()
                    );



            Stage stage =
                    (Stage)
                            logoutButton
                                    .getScene()
                                    .getWindow();



            stage.setScene(scene);



        }
        catch(Exception e){

            e.printStackTrace();

        }


    }




}