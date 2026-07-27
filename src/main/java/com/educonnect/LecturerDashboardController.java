package com.educonnect;

import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.fxml.FXML;
import javafx.scene.control.ListView;
import javafx.scene.control.TextArea;

public class LecturerDashboardController {

    @FXML
    private ListView<String> postsListView;

    @FXML
    private TextArea postContentArea;

    @FXML
    public void initialize() {
        loadPosts();
    }

    // Load posts dynamically from Laravel API with local fallback
    private void loadPosts() {
        ObservableList<String> postItems = FXCollections.observableArrayList();

        // Attempt to fetch live posts from Laravel backend
        String response = ApiService.getPosts();

        if (response != null && !response.isEmpty()) {
            // Parse JSON response from Laravel and populate postItems
            postItems.add("Loaded live from Laravel backend successfully.");
            // TODO: Parse your JSON array and add actual post titles/bodies
        } else {
            // Fallback: Load from local SQLite database if offline
            System.out.println("Backend offline. Loading cached posts from local SQLite...");
            // List<String> localPosts = DatabaseHandler.getLocalPosts();
            // postItems.addAll(localPosts);
            postItems.add("[Offline Mode] Cached local post item.");
        }

        if (postsListView != null) {
            postsListView.setItems(postItems);
        }
    }

    // Handle creating a post (works online or offline)
    @FXML
    private void handleCreatePost() {
        String content = postContentArea != null ? postContentArea.getText().trim() : "";
        if (content.isEmpty()) return;

        // Try sending directly to Laravel backend
        boolean success = ApiService.createPost(content);

        if (success) {
            System.out.println("Post published live to Laravel!");
            postContentArea.clear();
        } else {
            // If offline, save to local SQLite queue for later synchronization
            System.out.println("No internet. Saving post to local SQLite offline queue...");
            DatabaseHandler.saveOfflinePost(content);
            System.out.println("Post queued. Will sync to Laravel automatically when internet returns.");
            postContentArea.clear();
        }

        // Refresh view
        loadPosts();
    }
    @FXML
    private void handleLogout() {
        try {
            javafx.stage.Stage stage = (javafx.stage.Stage) postsListView.getScene().getWindow();
            javafx.fxml.FXMLLoader loader = new javafx.fxml.FXMLLoader(getClass().getResource("/view/login.fxml"));
            javafx.scene.Scene scene = new javafx.scene.Scene(loader.load());
            stage.setTitle("EduConnect - Login");
            stage.setScene(scene);
            stage.centerOnScreen();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}