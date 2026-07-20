package com.educonnect;

import javafx.fxml.FXML;
import javafx.scene.control.*;
import javafx.stage.FileChooser;
import javafx.stage.Stage;

import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.pdmodel.PDPage;
import org.apache.pdfbox.pdmodel.PDPageContentStream;
import org.apache.pdfbox.pdmodel.font.PDType1Font;
import org.apache.pdfbox.pdmodel.font.Standard14Fonts;

import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;
import java.util.List;

public class QuizController {

    @FXML private Label quizTitleLabel;
    @FXML private Label progressLabel;
    @FXML private Label questionTextLabel;
    @FXML private RadioButton optionA;
    @FXML private RadioButton optionB;
    @FXML private RadioButton optionC;
    @FXML private RadioButton optionD;
    @FXML private ToggleGroup optionsGroup;
    @FXML private Label resultLabel;
    @FXML private Button nextButton;
    @FXML private Button exportButton;

    private String username = "Student";
    private final List<Question> questions = new ArrayList<>();
    private int currentQuestionIndex = 0;
    private int score = 0;

    private static class Question {
        String text;
        String[] options;
        int correctIndex;

        Question(String text, String[] options, int correctIndex) {
            this.text = text;
            this.options = options;
            this.correctIndex = correctIndex;
        }
    }

    @FXML
    public void initialize() {
        loadDefaultQuestions();
        displayQuestion();
    }

    public void setUsername(String username) {
        this.username = username;
    }

    private void loadDefaultQuestions() {
        questions.add(new Question(
                "What architectural pattern is commonly used in JavaFX for separating UI from logic?",
                new String[]{"A) Model-View-Controller (MVC)", "B) Singleton", "C) Factory Pattern", "D) Prototype"},
                0
        ));
        questions.add(new Question(
                "Which SQLite statement is used to fetch records from a database table?",
                new String[]{"A) INSERT", "B) SELECT", "C) UPDATE", "D) DELETE"},
                1
        ));
        questions.add(new Question(
                "In EduConnect, which class is responsible for executing SQL database operations?",
                new String[]{"A) App", "B) DashboardController", "C) DatabaseHandler", "D) Main"},
                2
        ));
    }

    private void displayQuestion() {
        if (currentQuestionIndex < questions.size()) {
            Question q = questions.get(currentQuestionIndex);
            progressLabel.setText("Question " + (currentQuestionIndex + 1) + " of " + questions.size());
            questionTextLabel.setText(q.text);

            optionA.setText(q.options[0]);
            optionB.setText(q.options[1]);
            optionC.setText(q.options[2]);
            optionD.setText(q.options[3]);

            optionsGroup.selectToggle(null);
        } else {
            showResults();
        }
    }

    @FXML
    private void handleNextQuestion() {
        RadioButton selected = (RadioButton) optionsGroup.getSelectedToggle();
        if (selected == null) {
            Alert alert = new Alert(Alert.AlertType.WARNING, "Please select an answer before proceeding.");
            alert.showAndWait();
            return;
        }

        Question q = questions.get(currentQuestionIndex);
        int selectedIndex = -1;
        if (selected == optionA) selectedIndex = 0;
        else if (selected == optionB) selectedIndex = 1;
        else if (selected == optionC) selectedIndex = 2;
        else if (selected == optionD) selectedIndex = 3;

        if (selectedIndex == q.correctIndex) {
            score++;
        }

        currentQuestionIndex++;
        displayQuestion();
    }

    private void showResults() {
        questionTextLabel.setText("Quiz Completed!");
        optionA.setVisible(false);
        optionB.setVisible(false);
        optionC.setVisible(false);
        optionD.setVisible(false);

        resultLabel.setText("Final Score: " + score + " / " + questions.size());
        nextButton.setDisable(true);
        exportButton.setDisable(false);

        DatabaseHandler.saveQuizResult(username, "JavaFX & Database Foundations", score, questions.size());
    }

    @FXML
    private void handleExportReport() {
        FileChooser fileChooser = new FileChooser();
        fileChooser.setTitle("Save Quiz Performance Report");
        fileChooser.setInitialFileName("EduConnect_Quiz_Report_" + username);

        // Filters including PDF
        FileChooser.ExtensionFilter pdfFilter = new FileChooser.ExtensionFilter("PDF Document (*.pdf)", "*.pdf");
        FileChooser.ExtensionFilter txtFilter = new FileChooser.ExtensionFilter("Text File (*.txt)", "*.txt");
        FileChooser.ExtensionFilter csvFilter = new FileChooser.ExtensionFilter("CSV Spreadsheet (*.csv)", "*.csv");
        FileChooser.ExtensionFilter mdFilter = new FileChooser.ExtensionFilter("Markdown Document (*.md)", "*.md");

        fileChooser.getExtensionFilters().addAll(pdfFilter, txtFilter, csvFilter, mdFilter);

        Stage stage = (Stage) exportButton.getScene().getWindow();
        File file = fileChooser.showSaveDialog(stage);

        if (file != null) {
            FileChooser.ExtensionFilter selectedFilter = fileChooser.getSelectedExtensionFilter();
            String timestamp = LocalDateTime.now().format(DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss"));
            double percentage = ((double) score / questions.size()) * 100;
            String status = (percentage >= 50 ? "PASSED" : "NEEDS IMPROVEMENT");

            try {
                if (selectedFilter == pdfFilter || file.getName().endsWith(".pdf")) {
                    generatePdfReport(file, timestamp, percentage, status);
                } else if (selectedFilter == csvFilter || file.getName().endsWith(".csv")) {
                    try (FileWriter writer = new FileWriter(file)) {
                        writer.write("Student,Assessment,Date,Score,Total,Percentage,Status\n");
                        writer.write(String.format("\"%s\",\"JavaFX & Database Foundations\",\"%s\",%d,%d,%.1f%%,\"%s\"\n",
                                username, timestamp, score, questions.size(), percentage, status));
                    }
                } else if (selectedFilter == mdFilter || file.getName().endsWith(".md")) {
                    try (FileWriter writer = new FileWriter(file)) {
                        writer.write("# 🎓 EduConnect Assessment Report\n\n");
                        writer.write("| Property | Details |\n| :--- | :--- |\n");
                        writer.write("| **Student** | " + username + " |\n");
                        writer.write("| **Assessment** | JavaFX & Database Foundations |\n");
                        writer.write("| **Date** | " + timestamp + " |\n");
                        writer.write("| **Score** | " + score + " / " + questions.size() + " |\n");
                        writer.write(String.format("| **Percentage** | %.1f%% |\n", percentage));
                        writer.write("| **Status** | **" + status + "** |\n");
                    }
                } else {
                    try (FileWriter writer = new FileWriter(file)) {
                        writer.write("===========================================\n");
                        writer.write("    EDUCONNECT ASSESSMENT PERFORMANCE REPORT\n");
                        writer.write("===========================================\n\n");
                        writer.write("Student Name:   " + username + "\n");
                        writer.write("Assessment:     JavaFX & Database Foundations\n");
                        writer.write("Date Completed: " + timestamp + "\n");
                        writer.write("Score:          " + score + " / " + questions.size() + "\n");
                        writer.write(String.format("Percentage:     %.1f%%\n", percentage));
                        writer.write("Status:         " + status + "\n\n");
                        writer.write("===========================================\n");
                    }
                }

                Alert alert = new Alert(Alert.AlertType.INFORMATION, "Report saved successfully as:\n" + file.getAbsolutePath());
                alert.showAndWait();
            } catch (IOException e) {
                e.printStackTrace();
                Alert alert = new Alert(Alert.AlertType.ERROR, "Failed to save the report file.");
                alert.showAndWait();
            }
        }
    }

    private void generatePdfReport(File file, String timestamp, double percentage, String status) throws IOException {
        try (PDDocument document = new PDDocument()) {
            PDPage page = new PDPage();
            document.addPage(page);

            try (PDPageContentStream contentStream = new PDPageContentStream(document, page)) {
                contentStream.beginText();
                contentStream.setFont(new PDType1Font(Standard14Fonts.FontName.HELVETICA_BOLD), 18);
                contentStream.newLineAtOffset(50, 750);
                contentStream.showText("EduConnect Assessment Performance Report");
                contentStream.endText();

                contentStream.beginText();
                contentStream.setFont(new PDType1Font(Standard14Fonts.FontName.HELVETICA), 12);
                contentStream.setLeading(22f);
                contentStream.newLineAtOffset(50, 700);

                contentStream.showText("Student Name:   " + username);
                contentStream.newLine();
                contentStream.showText("Assessment:     JavaFX & Database Foundations");
                contentStream.newLine();
                contentStream.showText("Date Completed: " + timestamp);
                contentStream.newLine();
                contentStream.showText("Score:          " + score + " / " + questions.size());
                contentStream.newLine();
                contentStream.showText(String.format("Percentage:     %.1f%%", percentage));
                contentStream.newLine();
                contentStream.showText("Status:         " + status);
                contentStream.endText();
            }

            document.save(file);
        }
    }
}