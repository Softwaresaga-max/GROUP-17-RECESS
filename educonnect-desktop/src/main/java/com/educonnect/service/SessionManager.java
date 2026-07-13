package com.educonnect.util;

public class SessionManager {

    private static String role;
    private static String userId;
    private static boolean termsAccepted;

    public static void setSession(String id, String userRole, boolean accepted) {
        userId = id;
        role = userRole;
        termsAccepted = accepted;
    }

    public static String getRole() {
        return role;
    }

    public static String getUserId() {
        return userId;
    }

    public static boolean hasAcceptedTerms() {
        return termsAccepted;
    }

    public static void clearSession() {
        userId = null;
        role = null;
        termsAccepted = false;
    }
}