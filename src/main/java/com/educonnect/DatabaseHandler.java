package com.educonnect;

import javafx.collections.FXCollections;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class DatabaseHandler {
    private static final String DB_URL = "jdbc:sqlite:educonnect_local.db";

    public static String getUserRole(String username) {
        // Returns role based on username for demo/offline purposes
        if (username != null && username.toLowerCase().contains("admin")) {
            return "ADMIN";
        } else if (username != null && (username.toLowerCase().contains("lec") || username.toLowerCase().contains("lecturer"))) {
            return "LECTURER";
        }
        return "STUDENT";
    }

    public static int getUnreadNotificationCount(String username) {
        return 2; // Default mock unread count
    }

    public static int getUnsyncedCount() {
        try (Connection conn = DriverManager.getConnection(DB_URL);
             Statement stmt = conn.createStatement();
             ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM offline_queue")) {
            if (rs.next()) {
                return rs.getInt(1);
            }
        } catch (Exception e) {
            // Table might not exist yet
        }
        return 0;
    }

    public static List<Post> getPosts(String category) {
        List<Post> posts = new ArrayList<>();
        // Add sample mock posts so the list view populates nicely
        posts.add(new Post(1, "Welcome", "Welcome to EduConnect offline mode!", "System Admin", "Announcements", "2026-06-25"));
        posts.add(new Post(2, "JavaFX Setup", "Make sure your FXML controllers are correctly mapped.", "Wanyama Joseph", "Software Engineering", "2026-06-26"));
        return posts;
    }

    public static boolean addPost(String author, String category, String title, String content) {
        LocalDatabaseService.saveOfflineAction("/posts", "{\"title\":\"" + title + "\", \"content\":\"" + content + "\"}");
        return true;
    }

    // Helper method called by dashboards when offline
    public static void saveOfflinePost(String content) {
        try {
            // Ensure table exists
            try (Connection conn = DriverManager.getConnection(DB_URL);
                 Statement stmt = conn.createStatement()) {
                stmt.execute("CREATE TABLE IF NOT EXISTS offline_queue (id INTEGER PRIMARY KEY AUTOINCREMENT, endpoint TEXT, payload TEXT, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
            }

            // Save action locally
            LocalDatabaseService.saveOfflineAction("/posts", "{\"content\":\"" + content + "\"}");
            System.out.println("Post successfully saved to local SQLite offline queue.");
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public static List<String> getCommentsForPost(int postId) {
        List<String> comments = new ArrayList<>();
        comments.add("Dr. Lule: Great initiative on the recess project.");
        return comments;
    }

    public static boolean addComment(int postId, String author, String text) {
        LocalDatabaseService.saveOfflineAction("/comments", "{\"post_id\":" + postId + ", \"comment\":\"" + text + "\"}");
        return true;
    }

    public static boolean deletePost(int postId) {
        return true;
    }

    public static List<String> getNotifications(String username) {
        List<String> notifs = new ArrayList<>();
        notifs.add("Your Software Design Document was reviewed.");
        notifs.add("New quiz available in the portal.");
        return notifs;
    }

    public static void markNotificationsAsRead(String username) {
        // Mark read logic
    }

    public static int markAllAsSynced() {
        int count = getUnsyncedCount();
        try (Connection conn = DriverManager.getConnection(DB_URL);
             Statement stmt = conn.createStatement()) {
            stmt.executeUpdate("DELETE FROM offline_queue");
        } catch (Exception e) {
            e.printStackTrace();
        }
        return count;
    }
}