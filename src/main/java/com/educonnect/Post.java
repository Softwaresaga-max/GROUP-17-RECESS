package com.educonnect;

public class Post {
    private int id;
    private String author;
    private String category;
    private String title;
    private String content;
    private String createdAt;

    public Post(int id, String author, String category, String title, String content, String createdAt) {
        this.id = id;
        this.author = author;
        this.category = category;
        this.title = title;
        this.content = content;
        this.createdAt = createdAt;
    }

    public int getId() { return id; }
    public String getAuthor() { return author; }
    public String getCategory() { return category; }
    public String getTitle() { return title; }
    public String getContent() { return content; }
    public String getCreatedAt() { return createdAt; }

    @Override
    public String toString() {
        return "[" + category + "] " + title + " — Posted by " + author;
    }
}