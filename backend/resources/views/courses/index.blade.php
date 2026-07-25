<x-app-sidebar>

<h2>📚 My Course</h2>

@if(auth()->user()->course)

<div style="background:white; padding:20px; border-radius:10px;">

    <h3>{{ auth()->user()->course->name }}</h3>

    <p>
        <strong>Course Code:</strong>
        {{ auth()->user()->course->code }}
    </p>

    <p>
        <strong>Class:</strong>
        {{ auth()->user()->classRoom->name ?? 'Not Assigned' }}
    </p>

</div>

@else

<div style="background:white; padding:20px; border-radius:10px;">

    <h3>No Course Assigned</h3>

    <p>Please contact your administrator to be enrolled in a course.</p>

</div>

@endif

<br>

<a href="{{ route('student.dashboard') }}">
    ← Back to Dashboard
</a>

</x-app-sidebar>