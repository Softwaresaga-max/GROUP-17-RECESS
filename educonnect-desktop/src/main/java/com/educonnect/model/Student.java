package com.educonnect.model;


public class Student {


    private String id;

    private String name;

    private String email;

    private String role;

    private String class_id;



    // ID
    public String getId(){

        return id;

    }



    // NAME
    public String getName(){

        return name;

    }



    // EMAIL
    public String getEmail(){

        return email;

    }



    // CLASS
    public String getClassName(){

        if(class_id == null || class_id.isEmpty()){

            return "Not Assigned";

        }

        return class_id;

    }



    // STATUS
    public boolean isActive(){

        return true;

    }



    // ROLE
    public String getRole(){

        return role;

    }



    // Optional direct getter
    public String getClass_id(){

        return class_id;

    }

}