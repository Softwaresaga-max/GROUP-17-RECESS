package com.educonnect;

import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.stage.Stage;

import java.io.IOException;

public class Main extends Application {

    @Override
    public void start(Stage stage) throws IOException {
        // Initialize the local SQLite database on app startup for offline storage
        LocalDatabaseService.initializeDatabase();

        // Load the new modern welcome landing page first
        FXMLLoader fxmlLoader = new FXMLLoader(Main.class.getResource("/view/welcome.fxml"));
        Scene scene = new Scene(fxmlLoader.load(), 1000, 700);

        stage.setTitle("EduConnect - Streamlining Communication");
        stage.setScene(scene);
        stage.centerOnScreen();
        stage.show();
    }

    public static void main(String[] args) {
        launch();
    }
}