package com.educonnect.controller;

import com.educonnect.util.SessionManager;

import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.control.Button;
import javafx.scene.layout.StackPane;
import javafx.scene.layout.VBox;


public class DashboardController {


    @FXML
    private VBox sideMenu;


    @FXML
    private StackPane contentArea;



    // ---------------- INITIALIZE ----------------

    @FXML
    public void initialize() {


        String role = SessionManager.getRole();


        if (role == null) {
            role = "student";
        }


        sideMenu.getChildren().clear();



        switch (role.toLowerCase()) {


            case "admin":
                loadAdminMenu();
                break;


            case "lecturer":
                loadLecturerMenu();
                break;


            default:
                loadStudentMenu();
                break;
        }



        loadView(getDefaultView(role));

    }





    // ---------------- ADMIN MENU ----------------


    private void loadAdminMenu() {


        addButton(
                "Users",
                "/modules/admin/users.fxml",
                "admin"
        );


        addButton(
                "Create New Users",
                "/modules/admin/user-form.fxml",
                "admin"
        );


        addButton(
                "Student Management",
                "/modules/admin/class-students.fxml",
                "admin"
        );

    }





    // ---------------- LECTURER MENU ----------------


    private void loadLecturerMenu() {


        addButton(
                "Classes",
                "/modules/lecturer/classes.fxml",
                "lecturer"
        );


        addButton(
                "Marks",
                "/modules/lecturer/marks.fxml",
                "lecturer"
        );

    }





    // ---------------- STUDENT MENU ----------------


    private void loadStudentMenu() {


        addButton(
                "Profile",
                "/modules/student/profile.fxml",
                "student"
        );


        addButton(
                "Results",
                "/modules/student/results.fxml",
                "student"
        );

    }





    // ---------------- BUTTON CREATION ----------------


    private void addButton(
            String title,
            String fxmlPath,
            String requiredRole
    ) {


        Button button = new Button(title);


        button.setMaxWidth(
                Double.MAX_VALUE
        );



        button.setOnAction(event -> {


            if (canAccess(requiredRole)) {


                loadView(fxmlPath);


            } else {


                System.out.println(
                        "Access denied"
                );

            }


        });



        sideMenu.getChildren()
                .add(button);

    }





    // ---------------- SECURITY ----------------


    private boolean canAccess(String requiredRole) {


        String currentRole =
                SessionManager.getRole();


        return currentRole != null
                &&
                currentRole.equalsIgnoreCase(
                        requiredRole
                );

    }





    // ---------------- VIEW LOADER ----------------


    private void loadView(String fxml) {


        try {


            FXMLLoader loader =
                    new FXMLLoader(
                            getClass()
                                    .getResource(fxml)
                    );



            if(loader.getLocation() == null) {


                System.out.println(
                        "FXML not found: "
                                + fxml
                );

                return;

            }



            Parent view =
                    loader.load();



            contentArea.getChildren()
                    .setAll(view);



        }
        catch(Exception e) {


            System.out.println(
                    "Failed to load: "
                            + fxml
            );


            e.printStackTrace();

        }

    }





    // ---------------- DEFAULT PAGE ----------------


    private String getDefaultView(String role) {


        if(role.equalsIgnoreCase("admin")) {


            return "/modules/admin/users.fxml";

        }



        if(role.equalsIgnoreCase("lecturer")) {


            return "/modules/lecturer/classes.fxml";

        }



        return "/modules/student/results.fxml";

    }

}