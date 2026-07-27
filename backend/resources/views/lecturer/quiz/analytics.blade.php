<x-app-sidebar>

<h2>📊 Quiz Analytics</h2>

<div class="analytics-grid">

    <div class="analytics-card">
        <h3>Quiz</h3>
        <p>{{ $quiz->title }}</p>
    </div>


    <div class="analytics-card">
        <h3>Students Attempted</h3>
        <p>{{ $totalStudents }}</p>
    </div>


    <div class="analytics-card">
        <h3>Average Score</h3>
        <p>{{ $averageScore }}</p>
    </div>

</div>


<div class="info-box">

<h3>Student Performance</h3>

<table>

<tr>
<th>Student</th>
<th>Score</th>
<th>Status</th>
</tr>


@foreach($attempts as $attempt)

<tr>

<td>
{{ $attempt->user->name }}
</td>

<td>
{{ $attempt->score }}
</td>

<td>
{{ $attempt->completed ? 'Completed' : 'Incomplete' }}
</td>

</tr>

@endforeach


</table>

</div>

</x-app-sidebar>