package com.educonnect;

import java.net.URI;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;


public class ApiService {


    private static final String BASE_URL =
            "http://127.0.0.1:8000/api";


    private static final HttpClient client =
            HttpClient.newHttpClient();



    // ================= USER SESSION =================

    public static int currentUserId = 0;

    public static String currentUserName = "";

    public static String currentUserRole = "";

    public static String authToken = "";





    // ================= LOGIN =================


    public static String login(String email, String password){


        try{


            String json =
                    "{"
                            +"\"email\":\""+email+"\","
                            +"\"password\":\""+password+"\""
                            +"}";


            HttpRequest request =
                    HttpRequest.newBuilder()
                            .uri(
                                    URI.create(
                                            BASE_URL+"/login"
                                    )
                            )
                            .header(
                                    "Content-Type",
                                    "application/json"
                            )
                            .header(
                                    "Accept",
                                    "application/json"
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
                    "Login Status: "
                            +response.statusCode()
            );


            System.out.println(
                    "Laravel Response: "
                            +response.body()
            );



            if(response.statusCode()==200){

                extractLoginDetails(
                        response.body()
                );

            }


            return response.body();


        }
        catch(Exception e){

            System.out.println(
                    "Login error: "
                            +e.getMessage()
            );

        }


        return null;

    }







    // ================= REGISTER =================


    public static String register(
            String name,
            String email,
            String password,
            String role
    ){


        try{


            String json =
                    "{"
                            +"\"name\":\""+name+"\","
                            +"\"email\":\""+email+"\","
                            +"\"password\":\""+password+"\","
                            +"\"role\":\""+role+"\""
                            +"}";



            HttpRequest request =
                    HttpRequest.newBuilder()
                            .uri(
                                    URI.create(
                                            BASE_URL+"/register"
                                    )
                            )
                            .header(
                                    "Content-Type",
                                    "application/json"
                            )
                            .header(
                                    "Accept",
                                    "application/json"
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
                    "Register Response: "
                            +response.body()
            );


            return response.body();


        }
        catch(Exception e){

            System.out.println(
                    "Register error: "
                            +e.getMessage()
            );

        }


        return null;

    }








    // ================= SAVE LOGIN DETAILS =================


    private static void extractLoginDetails(
            String response
    ){


        try{


            currentUserId =
                    Integer.parseInt(
                            response.split("\"id\":")[1]
                                    .split(",")[0]
                                    .trim()
                    );



            currentUserName =
                    response.split("\"name\":\"")[1]
                            .split("\"")[0];



            currentUserRole =
                    response.split("\"role\":\"")[1]
                            .split("\"")[0];



            authToken =
                    response.split("\"token\":\"")[1]
                            .split("\"")[0];



            System.out.println(
                    "User ID: "
                            +currentUserId
            );


            System.out.println(
                    "Token saved"
            );


        }
        catch(Exception e){


            System.out.println(
                    "Failed saving login details"
            );


        }


    }








    // ================= COMPLETE ONBOARDING =================


    public static String completeOnboarding(
            String registrationCode,
            int classId
    ){


        try{


            String json =
                    "{"
                            +"\"registration_code\":\""+registrationCode+"\","
                            +"\"class_id\":"+classId
                            +"}";



            HttpRequest request =
                    HttpRequest.newBuilder()
                            .uri(
                                    URI.create(
                                            BASE_URL+
                                                    "/complete-onboarding"
                                    )
                            )
                            .header(
                                    "Content-Type",
                                    "application/json"
                            )
                            .header(
                                    "Accept",
                                    "application/json"
                            )
                            .header(
                                    "Authorization",
                                    "Bearer "+authToken
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
                    "Onboarding Status: "
                            +response.statusCode()
            );



            System.out.println(
                    response.body()
            );



            return response.body();



        }
        catch(Exception e){


            System.out.println(
                    "Onboarding error: "
                            +e.getMessage()
            );


        }



        return null;

    }
    // ================= GET COURSES =================


    public static String getCourses(){

        return sendGetRequest(
                "/courses"
        );

    }





    // ================= GET QUIZZES =================


    public static String getQuizzes(){

        return sendGetRequest(
                "/quizzes"
        );

    }






    // ================= GET SINGLE QUIZ =================


    public static String getQuiz(int quizId){

        return sendGetRequest(
                "/quizzes/"+quizId
        );

    }







    // ================= GET POSTS =================


    public static String getPosts(){

        return sendGetRequest(
                "/posts"
        );

    }








    // ================= CREATE POST =================


    public static boolean createPost(
            String content
    ){


        String json =
                "{"
                        +"\"content\":\""+content+"\""
                        +"}";



        String response =
                sendPostRequest(
                        "/posts",
                        json
                );



        return response != null;


    }









    // ================= HTTP GET =================


    private static String sendGetRequest(
            String endpoint
    ){


        try{


            HttpRequest request =
                    HttpRequest.newBuilder()
                            .uri(
                                    URI.create(
                                            BASE_URL+endpoint
                                    )
                            )
                            .header(
                                    "Authorization",
                                    "Bearer "+authToken
                            )
                            .header(
                                    "Accept",
                                    "application/json"
                            )
                            .GET()
                            .build();




            HttpResponse<String> response =
                    client.send(
                            request,
                            HttpResponse.BodyHandlers.ofString()
                    );



            System.out.println(
                    "GET "
                            +endpoint
                            +" STATUS: "
                            +response.statusCode()
            );



            System.out.println(
                    response.body()
            );



            return response.body();



        }
        catch(Exception e){


            System.out.println(
                    "GET error: "
                            +e.getMessage()
            );


        }



        return null;

    }









    // ================= HTTP POST =================


    private static String sendPostRequest(
            String endpoint,
            String json
    ){


        try{


            HttpRequest request =
                    HttpRequest.newBuilder()
                            .uri(
                                    URI.create(
                                            BASE_URL+endpoint
                                    )
                            )
                            .header(
                                    "Content-Type",
                                    "application/json"
                            )
                            .header(
                                    "Accept",
                                    "application/json"
                            )
                            .header(
                                    "Authorization",
                                    "Bearer "+authToken
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
                    "POST "
                            +endpoint
                            +" STATUS: "
                            +response.statusCode()
            );



            return response.body();



        }
        catch(Exception e){


            System.out.println(
                    "POST error: "
                            +e.getMessage()
            );


        }



        return null;

    }









    // ================= TEST CONNECTION =================


    public static String testConnection(){

        return sendGetRequest(
                "/test"
        );

    }
// ================= GET QUIZ QUESTIONS =================

    public static String getQuizQuestions(int id){

        return sendGetRequest(
                "/quizzes/" + id + "/questions"
        );

    }


}