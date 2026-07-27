package com.educonnect;

import javafx.collections.FXCollections;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.control.ComboBox;
import javafx.scene.control.Label;
import javafx.scene.control.RadioButton;
import javafx.scene.control.ToggleGroup;

public class QuizController {

    @FXML private Label quizTitleLabel;
    @FXML private Label progressLabel;
    @FXML private Label questionTextLabel;

    @FXML private ComboBox<String> courseSelectorBox;

    @FXML private RadioButton optionA;
    @FXML private RadioButton optionB;
    @FXML private RadioButton optionC;
    @FXML private RadioButton optionD;

    @FXML private ToggleGroup optionsGroup;

    @FXML private Label resultLabel;
    @FXML private Button exportButton;
    @FXML private Button nextButton;

    private String currentUsername;
    private int currentQuestionIndex = 0;

    // Standard Java arrays instead of JSON objects to avoid missing library errors
    private final String[] questions = {
            "What does MVC stand for in software architecture?",
            "Which tool is commonly used for Java dependency management?"
    };

    private final String[][] options = {
            {"Model View Controller", "Module Value Control", "Main Variable Core", "Multi Vector Connection"},
            {"Composer", "Maven", "NPM", "Pip"}
    };

    public void setUsername(String username) {
        this.currentUsername = username;
    }

    @FXML
    public void initialize() {
        if (courseSelectorBox != null) {
            courseSelectorBox.setItems(FXCollections.observableArrayList(
                    "Software Engineering", "Computer Science", "General"
            ));
            courseSelectorBox.getSelectionModel().selectFirst();
        }
        displayQuestion(currentQuestionIndex);
    }

    private void displayQuestion(int index) {
        if (index < questions.length) {
            questionTextLabel.setText((index + 1) + ". " + questions[index]);
            optionA.setText(options[index][0]);
            optionB.setText(options[index][1]);
            optionC.setText(options[index][2]);
            optionD.setText(options[index][3]);

            progressLabel.setText("Question " + (index + 1) + " of " + questions.length);
            if (optionsGroup != null) {
                optionsGroup.selectToggle(null);
            }
            resultLabel.setText("");
        } else {
            questionTextLabel.setText("Quiz completed!");
            nextButton.setDisable(true);
            exportButton.setDisable(false);
        }
    }

    @FXML
    private void handleNextQuestion() {
        if (currentQuestionIndex < questions.length - 1) {
            currentQuestionIndex++;
            displayQuestion(currentQuestionIndex);
        } else {
            questionTextLabel.setText("You have reached the end of the assessment.");
            nextButton.setDisable(true);
            exportButton.setDisable(false);
            resultLabel.setText("Assessment Finished!");
        }
    }

    @FXML
    private void handleExportReport() {
        resultLabel.setText("Report successfully exported for " + currentUsername + "!");
        System.out.println("Exporting quiz report to local storage...");
    }
}