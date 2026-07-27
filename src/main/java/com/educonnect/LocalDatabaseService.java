package com.educonnect;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.Statement;
import java.sql.PreparedStatement;
import java.sql.ResultSet;

public class LocalDatabaseService {
    private static final String DB_URL = "jdbc:sqlite:educonnect_local.db";

    // Initialize the local SQLite table for offline actions
    public static void initializeDatabase() {
        try (Connection conn = DriverManager.getConnection(DB_URL);
             Statement stmt = conn.createStatement()) {
            String sql = "CREATE TABLE IF NOT EXISTS offline_queue (" +
                    "id INTEGER PRIMARY KEY AUTOINCREMENT, " +
                    "endpoint TEXT NOT NULL, " +
                    "payload TEXT NOT NULL)";
            stmt.execute(sql);
            System.out.println("Local SQLite database initialized successfully.");
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    // Save an action locally when offline
    public static void saveOfflineAction(String endpoint, String payload) {
        try (Connection conn = DriverManager.getConnection(DB_URL);
             PreparedStatement pstmt = conn.prepareStatement("INSERT INTO offline_queue(endpoint, payload) VALUES(?, ?)")) {
            pstmt.setString(1, endpoint);
            pstmt.setString(2, payload);
            pstmt.executeUpdate();
            System.out.println("Action saved locally to SQLite for later synchronization.");
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}