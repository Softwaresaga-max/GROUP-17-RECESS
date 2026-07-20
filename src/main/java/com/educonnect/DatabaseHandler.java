package com.educonnect;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class DatabaseHandler {
    private static final String DB_URL = "jdbc:sqlite:educonnect.db";

    public static Connection connect() throws SQLException {
        return DriverManager.getConnection(DB_URL);
    }

    public static void initializeDatabase() {
        String createUsersTable = """
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT UNIQUE NOT NULL,
                password TEXT NOT NULL,
                role TEXT NOT NULL DEFAULT 'STUDENT'
            );
        """;

        String createPostsTable = """
            CREATE TABLE IF NOT EXISTS posts (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                author TEXT NOT NULL,
                category TEXT NOT NULL DEFAULT 'General',
                title TEXT NOT NULL,
                content TEXT NOT NULL,
                synced INTEGER DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        """;

        String createCommentsTable = """
            CREATE TABLE IF NOT EXISTS comments (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                post_id INTEGER NOT NULL,
                author TEXT NOT NULL,
                content TEXT NOT NULL,
                synced INTEGER DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY(post_id) REFERENCES posts(id) ON DELETE CASCADE
            );
        """;

        String createQuizTable = """
            CREATE TABLE IF NOT EXISTS quiz_results (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT NOT NULL,
                quiz_title TEXT NOT NULL,
                score INTEGER NOT NULL,
                total_questions INTEGER NOT NULL,
                taken_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        """;

        String createNotificationsTable = """
            CREATE TABLE IF NOT EXISTS notifications (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                recipient TEXT NOT NULL,
                message TEXT NOT NULL,
                is_read INTEGER DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        """;

        String insertDefaultAdmin = """
            INSERT OR IGNORE INTO users (username, password, role) 
            VALUES ('admin', 'admin123', 'ADMIN');
        """;

        try (Connection conn = connect();
             Statement stmt = conn.createStatement()) {
            stmt.execute(createUsersTable);
            stmt.execute(createPostsTable);
            stmt.execute(createCommentsTable);
            stmt.execute(createQuizTable);
            stmt.execute(createNotificationsTable);
            stmt.execute(insertDefaultAdmin);

            try {
                stmt.execute("ALTER TABLE posts ADD COLUMN category TEXT NOT NULL DEFAULT 'General';");
            } catch (SQLException ignored) {}

            System.out.println("Database fully initialized.");
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public static boolean registerUser(String username, String password) {
        String insertQuery = "INSERT INTO users (username, password, role) VALUES (?, ?, 'STUDENT')";
        try (Connection conn = connect();
             PreparedStatement pstmt = conn.prepareStatement(insertQuery)) {
            pstmt.setString(1, username);
            pstmt.setString(2, password);
            pstmt.executeUpdate();
            return true;
        } catch (SQLException e) {
            return false;
        }
    }

    public static boolean authenticateUser(String username, String password) {
        String selectQuery = "SELECT * FROM users WHERE username = ? AND password = ?";
        try (Connection conn = connect();
             PreparedStatement pstmt = conn.prepareStatement(selectQuery)) {
            pstmt.setString(1, username);
            pstmt.setString(2, password);
            ResultSet rs = pstmt.executeQuery();
            return rs.next();
        } catch (SQLException e) {
            return false;
        }
    }

    public static String getUserRole(String username) {
        String query = "SELECT role FROM users WHERE username = ?";
        try (Connection conn = connect();
             PreparedStatement pstmt = conn.prepareStatement(query)) {
            pstmt.setString(1, username);
            ResultSet rs = pstmt.executeQuery();
            if (rs.next()) {
                return rs.getString("role");
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return "STUDENT";
    }

    public static boolean addPost(String author, String category, String title, String content) {
        String insertQuery = "INSERT INTO posts (author, category, title, content, synced) VALUES (?, ?, ?, ?, 0)";
        try (Connection conn = connect();
             PreparedStatement pstmt = conn.prepareStatement(insertQuery)) {
            pstmt.setString(1, author);
            pstmt.setString(2, category);
            pstmt.setString(3, title);
            pstmt.setString(4, content);
            pstmt.executeUpdate();

            if ("Announcements".equalsIgnoreCase(category)) {
                createBroadcastNotification("📢 Announcement: " + title);
            }

            return true;
        } catch (SQLException e) {
            e.printStackTrace();
            return false;
        }
    }

    public static boolean deletePost(int postId) {
        String deleteComments = "DELETE FROM comments WHERE post_id = ?";
        String deletePost = "DELETE FROM posts WHERE id = ?";
        try (Connection conn = connect()) {
            try (PreparedStatement pstmt1 = conn.prepareStatement(deleteComments)) {
                pstmt1.setInt(1, postId);
                pstmt1.executeUpdate();
            }
            try (PreparedStatement pstmt2 = conn.prepareStatement(deletePost)) {
                pstmt2.setInt(1, postId);
                pstmt2.executeUpdate();
            }
            return true;
        } catch (SQLException e) {
            e.printStackTrace();
            return false;
        }
    }

    public static List<Post> getPosts(String filterCategory) {
        List<Post> posts = new ArrayList<>();
        String selectQuery = (filterCategory == null || filterCategory.equals("All"))
                ? "SELECT * FROM posts ORDER BY id DESC"
                : "SELECT * FROM posts WHERE category = ? ORDER BY id DESC";

        try (Connection conn = connect();
             PreparedStatement pstmt = conn.prepareStatement(selectQuery)) {
            if (filterCategory != null && !filterCategory.equals("All")) {
                pstmt.setString(1, filterCategory);
            }
            ResultSet rs = pstmt.executeQuery();
            while (rs.next()) {
                posts.add(new Post(
                        rs.getInt("id"),
                        rs.getString("author"),
                        rs.getString("category"),
                        rs.getString("title"),
                        rs.getString("content"),
                        rs.getString("created_at")
                ));
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return posts;
    }

    public static boolean addComment(int postId, String author, String content) {
        String insertQuery = "INSERT INTO comments (post_id, author, content, synced) VALUES (?, ?, ?, 0)";
        try (Connection conn = connect();
             PreparedStatement pstmt = conn.prepareStatement(insertQuery)) {
            pstmt.setInt(1, postId);
            pstmt.setString(2, author);
            pstmt.setString(3, content);
            pstmt.executeUpdate();

            String getAuthorQuery = "SELECT author, title FROM posts WHERE id = ?";
            try (PreparedStatement authorStmt = conn.prepareStatement(getAuthorQuery)) {
                authorStmt.setInt(1, postId);
                ResultSet rs = authorStmt.executeQuery();
                if (rs.next()) {
                    String postAuthor = rs.getString("author");
                    String postTitle = rs.getString("title");
                    if (!postAuthor.equals(author)) {
                        addNotification(postAuthor, "💬 " + author + " replied to your thread: '" + postTitle + "'");
                    }
                }
            }

            return true;
        } catch (SQLException e) {
            e.printStackTrace();
            return false;
        }
    }

    public static List<String> getCommentsForPost(int postId) {
        List<String> comments = new ArrayList<>();
        String selectQuery = "SELECT author, content, created_at FROM comments WHERE post_id = ? ORDER BY id ASC";
        try (Connection conn = connect();
             PreparedStatement pstmt = conn.prepareStatement(selectQuery)) {
            pstmt.setInt(1, postId);
            ResultSet rs = pstmt.executeQuery();
            while (rs.next()) {
                comments.add("💬 " + rs.getString("author") + ": " + rs.getString("content"));
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return comments;
    }

    public static void addNotification(String recipient, String message) {
        String query = "INSERT INTO notifications (recipient, message) VALUES (?, ?)";
        try (Connection conn = connect();
             PreparedStatement pstmt = conn.prepareStatement(query)) {
            pstmt.setString(1, recipient);
            pstmt.setString(2, message);
            pstmt.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public static void createBroadcastNotification(String message) {
        String query = "INSERT INTO notifications (recipient, message) SELECT username, ? FROM users";
        try (Connection conn = connect();
             PreparedStatement pstmt = conn.prepareStatement(query)) {
            pstmt.setString(1, message);
            pstmt.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public static List<String> getNotifications(String username) {
        List<String> list = new ArrayList<>();
        String query = "SELECT message, created_at FROM notifications WHERE recipient = ? ORDER BY id DESC LIMIT 15";
        try (Connection conn = connect();
             PreparedStatement pstmt = conn.prepareStatement(query)) {
            pstmt.setString(1, username);
            ResultSet rs = pstmt.executeQuery();
            while (rs.next()) {
                list.add(rs.getString("message") + " (" + rs.getString("created_at") + ")");
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return list;
    }

    public static int getUnreadNotificationCount(String username) {
        String query = "SELECT COUNT(*) FROM notifications WHERE recipient = ? AND is_read = 0";
        try (Connection conn = connect();
             PreparedStatement pstmt = conn.prepareStatement(query)) {
            pstmt.setString(1, username);
            ResultSet rs = pstmt.executeQuery();
            if (rs.next()) return rs.getInt(1);
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return 0;
    }

    public static void markNotificationsAsRead(String username) {
        String query = "UPDATE notifications SET is_read = 1 WHERE recipient = ?";
        try (Connection conn = connect();
             PreparedStatement pstmt = conn.prepareStatement(query)) {
            pstmt.setString(1, username);
            pstmt.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public static boolean saveQuizResult(String username, String quizTitle, int score, int totalQuestions) {
        String insertQuery = "INSERT INTO quiz_results (username, quiz_title, score, total_questions) VALUES (?, ?, ?, ?)";
        try (Connection conn = connect();
             PreparedStatement pstmt = conn.prepareStatement(insertQuery)) {
            pstmt.setString(1, username);
            pstmt.setString(2, quizTitle);
            pstmt.setInt(3, score);
            pstmt.setInt(4, totalQuestions);
            pstmt.executeUpdate();
            return true;
        } catch (SQLException e) {
            e.printStackTrace();
            return false;
        }
    }

    public static int getTotalUsers() {
        String query = "SELECT COUNT(*) FROM users";
        try (Connection conn = connect();
             Statement stmt = conn.createStatement();
             ResultSet rs = stmt.executeQuery(query)) {
            if (rs.next()) return rs.getInt(1);
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return 0;
    }

    public static int getTotalPosts() {
        String query = "SELECT COUNT(*) FROM posts";
        try (Connection conn = connect();
             Statement stmt = conn.createStatement();
             ResultSet rs = stmt.executeQuery(query)) {
            if (rs.next()) return rs.getInt(1);
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return 0;
    }

    public static int getTotalComments() {
        String query = "SELECT COUNT(*) FROM comments";
        try (Connection conn = connect();
             Statement stmt = conn.createStatement();
             ResultSet rs = stmt.executeQuery(query)) {
            if (rs.next()) return rs.getInt(1);
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return 0;
    }

    public static String getQuizAnalytics(String username) {
        String query = "SELECT AVG(score), COUNT(*) FROM quiz_results WHERE username = ?";
        try (Connection conn = connect();
             PreparedStatement pstmt = conn.prepareStatement(query)) {
            pstmt.setString(1, username);
            ResultSet rs = pstmt.executeQuery();
            if (rs.next() && rs.getInt(2) > 0) {
                double avg = rs.getDouble(1);
                int count = rs.getInt(2);
                return String.format("Quizzes Taken: %d | Avg Score: %.1f", count, avg);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return "No quizzes taken yet.";
    }

    public static int getUnsyncedCount() {
        String postsQuery = "SELECT COUNT(*) FROM posts WHERE synced = 0";
        String commentsQuery = "SELECT COUNT(*) FROM comments WHERE synced = 0";
        int total = 0;

        try (Connection conn = connect();
             Statement stmt = conn.createStatement()) {
            ResultSet rs1 = stmt.executeQuery(postsQuery);
            if (rs1.next()) total += rs1.getInt(1);

            ResultSet rs2 = stmt.executeQuery(commentsQuery);
            if (rs2.next()) total += rs2.getInt(1);
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return total;
    }

    public static int markAllAsSynced() {
        String syncPosts = "UPDATE posts SET synced = 1 WHERE synced = 0";
        String syncComments = "UPDATE comments SET synced = 1 WHERE synced = 0";
        int count = 0;

        try (Connection conn = connect();
             Statement stmt = conn.createStatement()) {
            count += stmt.executeUpdate(syncPosts);
            count += stmt.executeUpdate(syncComments);
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return count;
    }
}