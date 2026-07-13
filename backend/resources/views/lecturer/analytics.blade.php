<x-app-sidebar>

<h2>📊 Lecturer Analytics</h2>

<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:15px; margin-top:20px;">

    <div style="background:white; padding:20px; border-radius:10px;">
        <h3>Total Discussions</h3>
        <p>{{ $discussions }}</p>
    </div>

    <div style="background:white; padding:20px; border-radius:10px;">
        <h3>Total Quizzes</h3>
        <p>{{ $quizzes }}</p>
    </div>

</div>

<br>

<a href="{{ route('lecturer.dashboard') }}">Back to Dashboard</a>

</x-app-sidebar>