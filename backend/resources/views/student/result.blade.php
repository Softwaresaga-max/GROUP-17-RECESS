@extends('layouts.app')

@section('content')

<div class="container text-center">

    <h2>Quiz Result</h2>

    <h4>{{ $quiz->title }}</h4>

    <div class="card p-4 shadow-sm mt-3">

        <h3>
            Your Score: {{ $attempt->score }}
        </h3>

        <p class="mt-2">
            You have already completed this quiz.
        </p>

    </div>

    <a href="{{ route('student.quizzes') }}" 
       class="btn btn-primary mt-3">

        Back to Quizzes

    </a>

</div>

@endsection