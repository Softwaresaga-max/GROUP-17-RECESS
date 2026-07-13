<x-app-sidebar>

<div class="card">

<h1>📝 Available Quizzes</h1>

<p>
Take quizzes assigned by your lecturers.
</p>

</div>


@forelse($quizzes as $quiz)

<div class="card">

<h2>
{{ $quiz->title }}
</h2>


<p>
{{ $quiz->description }}
</p>


<p>
📅 Date:
{{ $quiz->quiz_date }}
</p>


<p>
⏱ Duration:
{{ $quiz->duration }} minutes
</p>


<a href="{{ route('quiz.start',$quiz->id) }}">

<button>
Start Quiz
</button>

</a>


</div>


@empty

<div class="card">

<p>
No quizzes available yet.
</p>

</div>

@endforelse


</x-app-sidebar>