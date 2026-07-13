<x-app-sidebar>

<h2>📋 Grading</h2>

<div style="background:white; padding:20px; border-radius:10px; margin-bottom:20px;">
    <h3>Participation Grading</h3>
    <p>Use discussion activity and quiz participation to award marks.</p>
</div>

<h3>Discussion Contributions</h3>

@forelse($discussions as $discussion)
    <div style="background:white; padding:15px; margin:10px 0; border-radius:10px;">
        <strong>{{ $discussion->title }}</strong><br>
        <small>By: {{ $discussion->user->name ?? 'Unknown' }}</small>
        <p>Suggested mark: 5</p>
    </div>
@empty
    <p>No discussions available for grading.</p>
@endforelse

<h3>Quizzes</h3>

@forelse($quizzes as $quiz)
    <div style="background:white; padding:15px; margin:10px 0; border-radius:10px;">
        <strong>{{ $quiz->title }}</strong><br>
        <small>Created by: {{ $quiz->user->name ?? 'Unknown' }}</small>
    </div>
@empty
    <p>No quizzes available.</p>
@endforelse

<br>

<a href="{{ route('lecturer.dashboard') }}">Back to Dashboard</a>

</x-app-sidebar>