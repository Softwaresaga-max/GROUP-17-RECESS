package com.educonnect.service;

import java.net.URI;
import java.net.http.*;
import java.util.*;

import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;

import java.lang.reflect.Type;

import com.educonnect.model.User;
import com.educonnect.model.Student;


public class ApiService {


    private static final String BASE_URL =
            "http://127.0.0.1:8000/api";


    private static final HttpClient client =
            HttpClient.newBuilder()
                    .build();


    // STORE LOGIN TOKEN
    public static String token;



    // ---------------- LOGIN ----------------

    public static String login(String email, String password)
            throws Exception {


        String json =
                """
                {
                    "email":"%s",
                    "password":"%s"
                }
                """.formatted(email,password);



        HttpRequest request =
                HttpRequest.newBuilder()
                        .uri(URI.create(BASE_URL + "/login"))
                        .header("Content-Type","application/json")
                        .header("Accept","application/json")
                        .POST(
                                HttpRequest.BodyPublishers.ofString(json)
                        )
                        .build();



        HttpResponse<String> response =
                client.send(
                        request,
                        HttpResponse.BodyHandlers.ofString()
                );


        System.out.println(
                "LOGIN RESPONSE: " + response.body()
        );


        return response.body();

    }




    // ---------------- GET USERS ----------------

    public static List<User> getUsers(){

        try{

            HttpRequest.Builder builder =
                    HttpRequest.newBuilder()
                            .uri(
                                    URI.create(BASE_URL + "/users")
                            )
                            .header(
                                    "Accept",
                                    "application/json"
                            );


            if(token != null){

                builder.header(
                        "Authorization",
                        "Bearer " + token
                );

            }


            HttpResponse<String> response =
                    client.send(
                            builder.GET().build(),
                            HttpResponse.BodyHandlers.ofString()
                    );


            Gson gson = new Gson();


            Type type =
                    new TypeToken<List<User>>(){}.getType();


            return gson.fromJson(
                    response.body(),
                    type
            );


        }
        catch(Exception e){

            e.printStackTrace();

            return new ArrayList<>();

        }

    }





    // ---------------- CREATE USER ----------------

    public static boolean createUser(
            String name,
            String email,
            String password,
            String role
    ){

        try{


            String json =
                    """
                    {
                     "name":"%s",
                     "email":"%s",
                     "password":"%s",
                     "role":"%s"
                    }
                    """.formatted(
                            name,email,password,role
                    );


            HttpRequest request =
                    HttpRequest.newBuilder()
                            .uri(
                                    URI.create(BASE_URL + "/users")
                            )
                            .header(
                                    "Content-Type",
                                    "application/json"
                            )
                            .header(
                                    "Authorization",
                                    "Bearer " + token
                            )
                            .POST(
                                    HttpRequest.BodyPublishers.ofString(json)
                            )
                            .build();



            HttpResponse<String> response =
                    client.send(
                            request,
                            HttpResponse.BodyHandlers.ofString()
                    );


            return response.statusCode()==200 ||
                    response.statusCode()==201;


        }
        catch(Exception e){

            e.printStackTrace();

            return false;

        }

    }





    // ---------------- DELETE USER ----------------

    public static String deleteUser(String id){

        try{

            HttpRequest request =
                    HttpRequest.newBuilder()
                            .uri(
                                    URI.create(
                                            BASE_URL+"/users/"+id
                                    )
                            )
                            .header(
                                    "Authorization",
                                    "Bearer "+token
                            )
                            .DELETE()
                            .build();


            HttpResponse<String> response =
                    client.send(
                            request,
                            HttpResponse.BodyHandlers.ofString()
                    );


            return response.body();


        }
        catch(Exception e){

            e.printStackTrace();

            return "error";

        }

    }





    // ---------------- GET STUDENTS ----------------

    public static List<Student> getStudents(){


        try{


            HttpRequest.Builder builder =
                    HttpRequest.newBuilder()
                            .uri(
                                    URI.create(BASE_URL+"/students")
                            )
                            .header(
                                    "Accept",
                                    "application/json"
                            );


            if(token != null){

                builder.header(
                        "Authorization",
                        "Bearer "+token
                );

            }



            HttpResponse<String> response =
                    client.send(
                            builder.GET().build(),
                            HttpResponse.BodyHandlers.ofString()
                    );


            System.out.println(
                    "STUDENTS API RESPONSE:"
            );

            System.out.println(
                    response.body()
            );



            Gson gson = new Gson();


            Type type =
                    new TypeToken<List<Student>>(){}.getType();



            return gson.fromJson(
                    response.body(),
                    type
            );


        }
        catch(Exception e){

            e.printStackTrace();

            return new ArrayList<>();

        }

    }





    // ---------------- ASSIGN STUDENT ----------------

    public static boolean assignStudent(
            String studentId,
            String classId
    ){


        try{


            String json =
                    """
                    {
                     "user_id":"%s",
                     "class_id":"%s"
                    }
                    """.formatted(
                            studentId,
                            classId
                    );



            HttpRequest request =
                    HttpRequest.newBuilder()
                            .uri(
                                    URI.create(
                                            BASE_URL+"/assign-student"
                                    )
                            )
                            .header(
                                    "Content-Type",
                                    "application/json"
                            )
                            .header(
                                    "Authorization",
                                    "Bearer "+token
                            )
                            .POST(
                                    HttpRequest.BodyPublishers.ofString(json)
                            )
                            .build();



            HttpResponse<String> response =
                    client.send(
                            request,
                            HttpResponse.BodyHandlers.ofString()
                    );


            System.out.println(
                    "ASSIGN STUDENT RESPONSE:"
            );

            System.out.println(
                    response.body()
            );


            return response.statusCode()==200;


        }
        catch(Exception e){

            e.printStackTrace();

            return false;

        }

    }


// ---------------- TOGGLE USER STATUS ----------------

    public static String toggleUser(String id)
    {

        try{

            HttpRequest request =
                    HttpRequest.newBuilder()
                            .uri(
                                    URI.create(
                                            BASE_URL
                                                    + "/users/"
                                                    + id
                                                    + "/toggle"
                                    )
                            )
                            .header(
                                    "Authorization",
                                    "Bearer " + token
                            )
                            .method(
                                    "PATCH",
                                    HttpRequest.BodyPublishers.noBody()
                            )
                            .build();



            HttpResponse<String> response =
                    client.send(
                            request,
                            HttpResponse.BodyHandlers.ofString()
                    );


            System.out.println(
                    "TOGGLE RESPONSE: "
                            + response.body()
            );


            return response.body();


        }
        catch(Exception e){

            e.printStackTrace();

            return "error";

        }

    }


    // ---------------- REMOVE STUDENT FROM CLASS ----------------

    public static boolean removeStudent(String studentId)
    {


        try{


            String json =
                    """
                    {
                     "user_id":"%s"
                    }
                    """.formatted(studentId);



            HttpRequest request =
                    HttpRequest.newBuilder()
                            .uri(
                                    URI.create(
                                            BASE_URL+"/remove-student"
                                    )
                            )
                            .header(
                                    "Content-Type",
                                    "application/json"
                            )
                            .header(
                                    "Authorization",
                                    "Bearer "+token
                            )
                            .POST(
                                    HttpRequest.BodyPublishers.ofString(json)
                            )
                            .build();



            HttpResponse<String> response =
                    client.send(
                            request,
                            HttpResponse.BodyHandlers.ofString()
                    );


            System.out.println(
                    "REMOVE STUDENT RESPONSE:"
            );

            System.out.println(
                    response.body()
            );


            return response.statusCode()==200;


        }
        catch(Exception e){

            e.printStackTrace();

            return false;

        }

    }

}