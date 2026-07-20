package com.educonnect;

import javafx.fxml.FXML;
import javafx.scene.control.Label;

public class AnalyticsController {

    @FXML private Label totalUsersLabel;
    @FXML private Label totalPostsLabel;
    @FXML private Label totalCommentsLabel;
    @FXML private Label userQuizStatsLabel;

    public void loadData(String currentUsername) {
        totalUsersLabel.setText(String.valueOf(DatabaseHandler.getTotalUsers()));
        totalPostsLabel.setText(String.valueOf(DatabaseHandler.getTotalPosts()));
        totalCommentsLabel.setText(String.valueOf(DatabaseHandler.getTotalComments()));
        userQuizStatsLabel.setText(DatabaseHandler.getQuizAnalytics(currentUsername));
    }
}