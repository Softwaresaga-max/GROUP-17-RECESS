package com.educonnect.controller.admin;

import com.educonnect.model.User;
import com.educonnect.service.ApiService;

import javafx.collections.FXCollections;
import javafx.collections.ObservableList;

import javafx.fxml.FXML;

import javafx.scene.control.*;

import javafx.scene.control.cell.PropertyValueFactory;


public class UsersController {


    @FXML
    private TableView<User> userTable;


    @FXML
    private TableColumn<User,String> idCol;


    @FXML
    private TableColumn<User,String> nameCol;


    @FXML
    private TableColumn<User,String> emailCol;


    @FXML
    private TableColumn<User,String> roleCol;


    @FXML
    private TableColumn<User,String> statusCol;



    private ObservableList<User> users =
            FXCollections.observableArrayList();



    @FXML
    public void initialize(){


        idCol.setCellValueFactory(
                new PropertyValueFactory<>("id")
        );


        nameCol.setCellValueFactory(
                new PropertyValueFactory<>("name")
        );


        emailCol.setCellValueFactory(
                new PropertyValueFactory<>("email")
        );


        roleCol.setCellValueFactory(
                new PropertyValueFactory<>("role")
        );


        statusCol.setCellValueFactory(
                new PropertyValueFactory<>("status")
        );


        loadUsers();

    }





    private void loadUsers(){


        users.clear();


        users.addAll(
                ApiService.getUsers()
        );


        userTable.setItems(users);

    }





    // + Add User button

    @FXML
    public void openAddUser(){

        System.out.println("Opening add user form");

    }





    // Edit User button

    @FXML
    public void editUser(){


        User selected =
                userTable.getSelectionModel()
                        .getSelectedItem();


        if(selected == null){

            showAlert("Select a user first");
            return;

        }


        System.out.println(
                "Editing: "
                        + selected.getName()
        );

    }





    // Delete User button

    @FXML
    public void deleteUser(){


        User selected =
                userTable.getSelectionModel()
                        .getSelectedItem();


        if(selected == null){

            showAlert("Select a user first");
            return;

        }


        ApiService.deleteUser(
                selected.getId()
        );


        loadUsers();

    }





    // Activate/Deactivate button

    @FXML
    public void toggleStatus(){


        User selected =
                userTable.getSelectionModel()
                        .getSelectedItem();


        if(selected == null){

            showAlert("Select a user first");
            return;

        }


        ApiService.toggleUser(
                selected.getId()
        );


        loadUsers();

    }





    private void showAlert(String message){


        Alert alert =
                new Alert(
                        Alert.AlertType.INFORMATION
                );


        alert.setContentText(message);


        alert.show();

    }

}