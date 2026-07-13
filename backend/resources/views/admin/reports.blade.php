<x-app-sidebar>

<h2>📊 System Reports</h2>

<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:15px; margin-top:20px;">

    <div style="background:white; padding:20px; border-radius:10px;">
        <h3>Total Users</h3>
        <p>{{ $users }}</p>
    </div>

    <div style="background:white; padding:20px; border-radius:10px;">
        <h3>Students</h3>
        <p>{{ $students }}</p>
    </div>

    <div style="background:white; padding:20px; border-radius:10px;">
        <h3>Lecturers</h3>
        <p>{{ $lecturers }}</p>
    </div>

    <div style="background:white; padding:20px; border-radius:10px;">
        <h3>Admins</h3>
        <p>{{ $admins }}</p>
    </div>

    <div style="background:white; padding:20px; border-radius:10px;">
        <h3>Discussions</h3>
        <p>{{ $discussions }}</p>
    </div>

    <div style="background:white; padding:20px; border-radius:10px;">
        <h3>Quizzes</h3>
        <p>{{ $quizzes }}</p>
    </div>

</div>

<br>

<a href="{{ route('admin.dashboard') }}">Back to Dashboard</a>

</x-app-sidebar>