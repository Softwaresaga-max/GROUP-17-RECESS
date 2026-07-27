package com.educonnect;

import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.control.ListView;
import javafx.stage.Stage;
import javafx.scene.Scene;
import javafx.fxml.FXMLLoader;
import javafx.scene.layout.VBox;
import javafx.scene.control.Label;

import java.util.List;

public class StudentDashboardController {

    @FXML
    private Button logoutButton;

    @FXML
    private void handleViewAnnouncements() {
        System.out.println("Fetching live announcements from Laravel / SQLite...");

        // Example dynamic implementation: fetch posts/announcements
        ObservableList<String> announcements = FXCollections.observableArrayList();
        String apiResponse = ApiService.getPosts(); // Calls Laravel backend

        if (apiResponse != null && !apiResponse.isEmpty()) {
            announcements.add(apiResponse);
        } else {
            // Offline fallback to SQLite
            List<Post> posts = DatabaseHandler.getPosts("announcement");
            for (Post p : posts) {
                announcements.add(p.getTitle() + ": " + p.getContent());
            }
            if (announcements.isEmpty()) {
                announcements.add("No announcements available at the moment.");
            }
        }

        // Display them in a popup window or switch view dynamically
        showDataPopup("Lecturer Announcements", announcements);
    }

    @FXML
    private void handleOpenForums() {
        System.out.println("Fetching student discussions from Laravel / SQLite...");

        ObservableList<String> discussions = FXCollections.observableArrayList();
        // Fetch discussion forum posts from database or Laravel API
        List<Post> forumPosts = DatabaseHandler.getPosts("forum");

        for (Post p : forumPosts) {
            discussions.add(p.getAuthor() + " says: " + p.getContent());
        }
        if (discussions.isEmpty()) {
            discussions.add("No student discussions found. Start a conversation!");
        }

        showDataPopup("Peer Discussion Forums", discussions);
    }

    @FXML
    private void handleTakeQuiz() {
        System.out.println("Loading active quizzes...");
        // Add logic to load your quiz interface view here
    }

    private void showDataPopup(String title, ObservableList<String> items) {
        Stage popupStage = new Stage();
        ListView<String> listView = new ListView<>(items);
        VBox vbox = new VBox(10, new Label(title), listView);
        vbox.setStyle("-fx-padding: 20; -fx-background-color: white;");

        Scene scene = new Scene(vbox, 450, 350);
        popupStage.setTitle(title);
        popupStage.setScene(scene);
        popupStage.show();
    }

    @FXML
    private void handleLogout() {
        try {
            Stage stage = (Stage) logoutButton.getScene().getWindow();
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/view/login.fxml"));
            Scene scene = new Scene(loader.load());
            stage.setTitle("EduConnect - Login");
            stage.setScene(scene);
            stage.centerOnScreen();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}