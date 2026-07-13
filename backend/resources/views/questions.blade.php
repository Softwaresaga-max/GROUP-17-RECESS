<x-app-sidebar>

<h2>Add Questions: {{ $quiz->title }}</h2>

<form method="POST" action="{{ route('quizzes.questions.store', $quiz) }}">
    @csrf

    <label>Question</label><br>
    <textarea name="question_text" required>{{ old('question_text') }}</textarea><br><br>

    <label>Option A</label><br>
    <input type="text" name="option_a" required><br><br>

    <label>Option B</label><br>
    <input type="text" name="option_b" required><br><br>

    <label>Option C</label><br>
    <input type="text" name="option_c" required><br><br>

    <label>Option D</label><br>
    <input type="text" name="option_d" required><br><br>

    <label>Correct Answer</label><br>
    <select name="correct_answer" required>
        <option value="">-- Select Correct Answer --</option>
        <option value="A">Option A</option>
        <option value="B">Option B</option>
        <option value="C">Option C</option>
        <option value="D">Option D</option>
    </select><br><br>

    <label>Marks</label><br>
    <input type="number" name="marks" min="1" value="1" required><br><br>

    <button type="submit">Save Question</button>
</form>

<hr>

<h3>Existing Questions</h3>

@forelse($quiz->questions as $question)
    <div style="background:white; padding:15px; margin:10px 0; border-radius:10px;">
        <strong>{{ $question->question_text }}</strong>
        <p>A. {{ $question->option_a }}</p>
        <p>B. {{ $question->option_b }}</p>
        <p>C. {{ $question->option_c }}</p>
        <p>D. {{ $question->option_d }}</p>
        <p><strong>Correct Answer:</strong> {{ $question->correct_answer }}</p>
        <p><strong>Marks:</strong> {{ $question->marks }}</p>
    </div>
@empty
    <p>No questions added yet.</p>
@endforelse

<br>

<a href="{{ route('quizzes.index') }}">Back to Quizzes</a>

</x-app-sidebar>