package com.educonnect.models;


public class Quiz {

    private int id;
    private String title;
    private String description;
    private int duration;
    private String status;


    public Quiz(
            int id,
            String title,
            String description,
            int duration,
            String status
    ){

        this.id = id;
        this.title = title;
        this.description = description;
        this.duration = duration;
        this.status = status;

    }



    public int getId(){

        return id;

    }


    public String getTitle(){

        return title;

    }


    public String getDescription(){

        return description;

    }


    public int getDuration(){

        return duration;

    }


    public String getStatus(){

        return status;

    }


}