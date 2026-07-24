<x-app-sidebar>

<h2>📊 Quiz Analytics</h2>

<h3>{{ $quiz->title }}</h3>

<hr>

<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px;">

    <div style="background:#fff;padding:20px;border-radius:10px;">
        <h3>{{ $totalStudents }}</h3>
        <p>Total Attempts</p>
    </div>

    <div style="background:#fff;padding:20px;border-radius:10px;">
        <h3>{{ number_format($averageScore,1) }}</h3>
        <p>Average Score</p>
    </div>

    <div style="background:#fff;padding:20px;border-radius:10px;">
        <h3>{{ $attempts->max('score') ?? 0 }}</h3>
        <p>Highest Score</p>
    </div>

    <div style="background:#fff;padding:20px;border-radius:10px;">
        <h3>{{ $attempts->min('score') ?? 0 }}</h3>
        <p>Lowest Score</p>
    </div>

</div>

<br>

<table border="1" cellpadding="10" width="100%">

<tr>
    <th>Student</th>
    <th>Email</th>
    <th>Score</th>
    <th>Status</th>
</tr>

@foreach($attempts as $attempt)

<tr>

<td>{{ $attempt->user->name }}</td>

<td>{{ $attempt->user->email }}</td>

<td>{{ $attempt->score }}</td>

<td>

@if($attempt->completed)

Completed

@else

Pending

@endif

</td>

</tr>

@endforeach

</table>

</x-app-sidebar>