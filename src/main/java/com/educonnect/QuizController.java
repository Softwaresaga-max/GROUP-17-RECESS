package com.educonnect;

import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.fxml.FXML;
import javafx.scene.control.Alert;
import javafx.scene.control.Label;
import javafx.scene.control.ListView;
import javafx.scene.control.RadioButton;
import javafx.scene.control.ToggleGroup;

import org.json.JSONArray;
import org.json.JSONObject;


public class QuizController {


    @FXML
    private ListView<String> quizListView;

    @FXML
    private Label quizTitleLabel;

    @FXML
    private Label questionLabel;

    @FXML
    private RadioButton optionA;

    @FXML
    private RadioButton optionB;

    @FXML
    private RadioButton optionC;

    @FXML
    private RadioButton optionD;

    @FXML
    private Label scoreLabel;



    private JSONArray quizzes;

    private JSONArray questions;


    private int currentQuestion = 0;

    private int score = 0;

    private String selectedAnswer = "";





    @FXML
    public void initialize(){


        ToggleGroup group = new ToggleGroup();


        optionA.setToggleGroup(group);
        optionB.setToggleGroup(group);
        optionC.setToggleGroup(group);
        optionD.setToggleGroup(group);



        group.selectedToggleProperty()
                .addListener((obs, oldValue, newValue) -> {


                    if(newValue == optionA){

                        selectedAnswer = "A";

                    }
                    else if(newValue == optionB){

                        selectedAnswer = "B";

                    }
                    else if(newValue == optionC){

                        selectedAnswer = "C";

                    }
                    else if(newValue == optionD){

                        selectedAnswer = "D";

                    }


                });



        loadQuizzes();



        quizListView.getSelectionModel()
                .selectedIndexProperty()
                .addListener((obs, oldValue, newValue) -> {


                    if(newValue != null && newValue.intValue() >= 0){

                        loadQuestions(
                                newValue.intValue()
                        );

                    }

                });


    }








    private void loadQuizzes(){


        try{


            String response =
                    ApiService.getQuizzes();



            System.out.println("QUIZZES:");
            System.out.println(response);



            quizzes =
                    new JSONArray(response);



            ObservableList<String> quizNames =
                    FXCollections.observableArrayList();



            for(int i = 0; i < quizzes.length(); i++){


                JSONObject quiz =
                        quizzes.getJSONObject(i);



                quizNames.add(
                        quiz.getString("title")
                );


            }



            quizListView.setItems(
                    quizNames
            );


        }
        catch(Exception e){


            e.printStackTrace();


            quizTitleLabel.setText(
                    "Failed loading quizzes"
            );


        }


    }









    private void loadQuestions(int index){


        try{


            JSONObject quiz =
                    quizzes.getJSONObject(index);



            int quizId =
                    quiz.getInt("id");



            String response =
                    ApiService.getQuizQuestions(
                            quizId
                    );



            System.out.println("QUESTIONS:");
            System.out.println(response);



            JSONObject data =
                    new JSONObject(response);



            questions =
                    data.getJSONArray(
                            "questions"
                    );



            quizTitleLabel.setText(
                    data.optString(
                            "quiz",
                            "Quiz"
                    )
            );



            currentQuestion = 0;

            score = 0;



            scoreLabel.setText(
                    "Score: 0"
            );



            optionA.setVisible(true);
            optionB.setVisible(true);
            optionC.setVisible(true);
            optionD.setVisible(true);



            displayQuestion();



        }
        catch(Exception e){


            e.printStackTrace();


            new Alert(
                    Alert.AlertType.ERROR,
                    "Failed loading questions"
            ).showAndWait();


        }


    }









    private void displayQuestion(){


        if(questions == null){

            return;

        }



        if(currentQuestion >= questions.length()){



            questionLabel.setText(
                    "Quiz Completed!"
            );



            scoreLabel.setText(
                    "Final Score: "
                            +score
                            +"/"
                            +getTotalMarks()
            );



            optionA.setVisible(false);
            optionB.setVisible(false);
            optionC.setVisible(false);
            optionD.setVisible(false);



            return;


        }






        JSONObject question =
                questions.getJSONObject(
                        currentQuestion
                );




        questionLabel.setText(

                (currentQuestion + 1)
                        + ". "
                        + question.getString(
                        "question_text"
                )

        );





        optionA.setText(
                "A. "
                        +question.getString("option_a")
        );


        optionB.setText(
                "B. "
                        +question.getString("option_b")
        );


        optionC.setText(
                "C. "
                        +question.getString("option_c")
        );


        optionD.setText(
                "D. "
                        +question.getString("option_d")
        );



        optionA.setSelected(false);
        optionB.setSelected(false);
        optionC.setSelected(false);
        optionD.setSelected(false);



        selectedAnswer = "";


    }









    @FXML
    private void handleNextQuestion(){



        if(selectedAnswer.isEmpty()){



            new Alert(
                    Alert.AlertType.WARNING,
                    "Select an answer first"
            ).showAndWait();



            return;

        }






        JSONObject question =
                questions.getJSONObject(
                        currentQuestion
                );




        String correct =
                question.getString(
                        "correct_answer"
                );



        if(selectedAnswer.equalsIgnoreCase(correct)){


            score += question.getInt(
                    "marks"
            );


        }




        currentQuestion++;



        scoreLabel.setText(
                "Score: "
                        +score
        );



        displayQuestion();


    }









    private int getTotalMarks(){


        int total = 0;



        for(int i = 0; i < questions.length(); i++){


            JSONObject q =
                    questions.getJSONObject(i);



            total += q.getInt(
                    "marks"
            );


        }



        return total;


    }


}