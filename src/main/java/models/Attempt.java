public class Attempt {
    private int id;
    private int userId;
    private int quizId;
    private Integer score;
    private boolean completed;

    // Getters and Setters
    public int getId() { return id; }
    public void setId(int id) { this.id = id; }

    public int getUserId() { return userId; }
    public void setUserId(int userId) { this.userId = userId; }

    public int getQuizId() { return quizId; }
    public void setQuizId(int quizId) { this.quizId = quizId; }

    public Integer getScore() { return score; }
    public void setScore(Integer score) { this.score = score; }

    public boolean isCompleted() { return completed; }
    public void setCompleted(boolean completed) { this.completed = completed; }
}