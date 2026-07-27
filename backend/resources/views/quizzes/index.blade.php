<x-app-sidebar>

<h2>📝 Quizzes</h2>

@if(auth()->user()->role === 'lecturer' || auth()->user()->role === 'admin')
    <a href="{{ route('quizzes.create') }}">➕ Create Quiz</a>
@endif

@forelse($quizzes as $quiz)
    <div style="background:white; padding:15px; margin:10px 0; border-radius:10px;">
        <h3>{{ $quiz->title }}</h3>

        <p>{{ $quiz->description ?? 'No description provided.' }}</p>

        Start: 
{{ $quiz->start_datetime 
    ? \Carbon\Carbon::parse($quiz->start_datetime)->format('d M Y, h:i A') 
    : 'Not set' }}

<br>

End: 
{{ $quiz->end_datetime 
    ? \Carbon\Carbon::parse($quiz->end_datetime)->format('d M Y, h:i A') 
    : 'Not set' }}

<br>

Duration: 
@if($quiz->start_datetime && $quiz->end_datetime)
    {{ \Carbon\Carbon::parse($quiz->start_datetime)->diffInMinutes($quiz->end_datetime) }} minutes
@else
    Not set
@endif
        <p><strong>Category:</strong> {{ $quiz->student_category ?? 'Not set' }}</p>
        <p><strong>Status:</strong> {{ $quiz->status ?? 'draft' }}</p>

        <small>Created by: {{ $quiz->user->name ?? 'Unknown' }}</small>

       @if(auth()->user()->role === 'lecturer' || auth()->user()->role === 'admin')

    <br><br>

    <a href="{{ route('quizzes.questions', $quiz) }}">
        ➕ Add Questions
    </a>

    <br><br>

    <a href="{{ route('quizzes.analytics', $quiz) }}">
        📊 View Analytics
    </a>

@endif
    </div>
@empty
    <p>No quizzes available yet.</p>
@endforelse

</x-app-sidebar>