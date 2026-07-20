package com.educonnect;

import javafx.collections.FXCollections;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.scene.layout.BorderPane;
import javafx.stage.Stage;

import java.io.IOException;
import java.util.List;
import java.util.stream.Collectors;

public class DashboardController {

    @FXML private BorderPane rootPane;
    @FXML private Label welcomeLabel;
    @FXML private Label syncStatusLabel;
    @FXML private Button notifButton;
    @FXML private TextField searchField;
    @FXML private ComboBox<String> categoryFilterBox;
    @FXML private ComboBox<String> newPostCategoryBox;
    @FXML private ListView<Post> postListView;
    @FXML private TextField postTitleField;
    @FXML private TextArea postContentArea;

    @FXML private Label selectedTitleLabel;
    @FXML private Label selectedAuthorLabel;
    @FXML private TextArea selectedContentArea;
    @FXML private ListView<String> commentListView;
    @FXML private TextField commentField;
    @FXML private Button deletePostButton;

    private String currentUsername;
    private String userRole = "STUDENT";
    private Post currentSelectedPost;
    private List<Post> allPosts;
    private boolean isDarkMode = false;

    @FXML
    public void initialize() {
        List<String> categories = List.of("General", "Software Engineering", "Computer Science", "Announcements");
        newPostCategoryBox.setItems(FXCollections.observableArrayList(categories));
        newPostCategoryBox.getSelectionModel().selectFirst();

        List<String> filterCategories = List.of("All", "General", "Software Engineering", "Computer Science", "Announcements");
        categoryFilterBox.setItems(FXCollections.observableArrayList(filterCategories));
        categoryFilterBox.getSelectionModel().selectFirst();

        postListView.getSelectionModel().selectedItemProperty().addListener((obs, oldVal, newVal) -> {
            if (newVal != null) {
                displayPostDetails(newVal);
            }
        });

        searchField.textProperty().addListener((obs, oldVal, newVal) -> filterPosts());

        rootPane.getStyleClass().add("light-theme");
        updateSyncStatus();
    }

    public void setUsername(String username) {
        this.currentUsername = username;
        this.userRole = DatabaseHandler.getUserRole(username);

        if ("ADMIN".equalsIgnoreCase(userRole)) {
            welcomeLabel.setText("Welcome, " + username + " [ADMIN 🛡️]");
            deletePostButton.setVisible(true);
        } else {
            welcomeLabel.setText("Welcome, " + username + "!");
            deletePostButton.setVisible(false);
        }

        loadPosts();
        updateNotificationsCount();
        updateSyncStatus();
    }

    private void updateNotificationsCount() {
        int unread = DatabaseHandler.getUnreadNotificationCount(currentUsername);
        notifButton.setText("🔔 (" + unread + ")");
    }

    private void updateSyncStatus() {
        int unsynced = DatabaseHandler.getUnsyncedCount();
        syncStatusLabel.setText("Pending Sync: " + unsynced);
    }

    private void loadPosts() {
        String filter = categoryFilterBox.getValue();
        allPosts = DatabaseHandler.getPosts(filter);
        filterPosts();
    }

    private void filterPosts() {
        if (allPosts == null) return;

        String query = searchField.getText().trim().toLowerCase();
        if (query.isEmpty()) {
            postListView.setItems(FXCollections.observableArrayList(allPosts));
        } else {
            List<Post> filtered = allPosts.stream()
                    .filter(p -> p.getTitle().toLowerCase().contains(query) || p.getContent().toLowerCase().contains(query))
                    .collect(Collectors.toList());
            postListView.setItems(FXCollections.observableArrayList(filtered));
        }
    }

    @FXML
    private void handleCategoryFilter() {
        loadPosts();
    }

    @FXML
    private void handleToggleTheme() {
        isDarkMode = !isDarkMode;
        rootPane.getStyleClass().removeAll("light-theme", "dark-theme");

        if (isDarkMode) {
            rootPane.getStyleClass().add("dark-theme");
        } else {
            rootPane.getStyleClass().add("light-theme");
        }
    }

    @FXML
    private void handlePostSubmit() {
        String category = newPostCategoryBox.getValue();
        String title = postTitleField.getText().trim();
        String content = postContentArea.getText().trim();

        if (title.isEmpty() || content.isEmpty()) return;

        if (DatabaseHandler.addPost(currentUsername, category, title, content)) {
            postTitleField.clear();
            postContentArea.clear();
            loadPosts();
            updateNotificationsCount();
            updateSyncStatus();
        }
    }

    private void displayPostDetails(Post post) {
        this.currentSelectedPost = post;
        selectedTitleLabel.setText("[" + post.getCategory() + "] " + post.getTitle());
        selectedAuthorLabel.setText("Posted by: " + post.getAuthor() + " on " + post.getCreatedAt());
        selectedContentArea.setText(post.getContent());
        loadComments();
    }

    private void loadComments() {
        if (currentSelectedPost != null) {
            List<String> comments = DatabaseHandler.getCommentsForPost(currentSelectedPost.getId());
            commentListView.setItems(FXCollections.observableArrayList(comments));
        }
    }

    @FXML
    private void handleCommentSubmit() {
        if (currentSelectedPost == null) return;
        String commentText = commentField.getText().trim();

        if (!commentText.isEmpty()) {
            if (DatabaseHandler.addComment(currentSelectedPost.getId(), currentUsername, commentText)) {
                commentField.clear();
                loadComments();
                updateNotificationsCount();
                updateSyncStatus();
            }
        }
    }

    @FXML
    private void handleDeletePost() {
        if (currentSelectedPost == null) return;

        Alert confirm = new Alert(Alert.AlertType.CONFIRMATION, "Are you sure you want to delete this thread?", ButtonType.YES, ButtonType.NO);
        confirm.setHeaderText("Admin Action: Delete Thread");
        confirm.showAndWait().ifPresent(response -> {
            if (response == ButtonType.YES) {
                if (DatabaseHandler.deletePost(currentSelectedPost.getId())) {
                    selectedTitleLabel.setText("Select a thread to read");
                    selectedAuthorLabel.setText("");
                    selectedContentArea.clear();
                    commentListView.getItems().clear();
                    currentSelectedPost = null;
                    loadPosts();
                }
            }
        });
    }

    @FXML
    private void handleOpenNotifications() {
        List<String> notifs = DatabaseHandler.getNotifications(currentUsername);
        DatabaseHandler.markNotificationsAsRead(currentUsername);
        updateNotificationsCount();

        Dialog<Void> dialog = new Dialog<>();
        dialog.setTitle("Notifications");
        dialog.setHeaderText("Activity & Announcements for " + currentUsername);

        ListView<String> listView = new ListView<>(FXCollections.observableArrayList(notifs));
        if (notifs.isEmpty()) {
            listView.getItems().add("No notifications yet.");
        }

        dialog.getDialogPane().setContent(listView);
        dialog.getDialogPane().getButtonTypes().add(ButtonType.CLOSE);
        dialog.showAndWait();
    }

    @FXML
    private void handleSyncData() {
        int syncedItems = DatabaseHandler.markAllAsSynced();
        updateSyncStatus();

        Alert alert = new Alert(Alert.AlertType.INFORMATION);
        alert.setTitle("Cloud Sync Complete");
        alert.setHeaderText("Offline Sync Manager");
        alert.setContentText("Successfully synced " + syncedItems + " pending record(s) to the backend REST API server!");
        alert.showAndWait();
    }

    @FXML
    private void handleOpenQuiz() {
        try {
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/view/quiz.fxml"));
            Parent root = loader.load();

            QuizController quizController = loader.getController();
            quizController.setUsername(currentUsername);

            Stage stage = new Stage();
            stage.setTitle("EduConnect - Quiz Assessment");
            stage.setScene(new Scene(root, 600, 450));
            stage.show();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    @FXML
    private void handleOpenAnalytics() {
        try {
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/view/analytics.fxml"));
            Parent root = loader.load();

            AnalyticsController analyticsController = loader.getController();
            analyticsController.loadData(currentUsername);

            Stage stage = new Stage();
            stage.setTitle("EduConnect - Engagement Analytics");
            stage.setScene(new Scene(root, 500, 400));
            stage.show();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
}