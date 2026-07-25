<!DOCTYPE html>
<html>
<head>
    <title>Student Progress</title>
</head>

<body>

<h1>Student Progress Tracking</h1>

<div>

<h3>Total Students:
{{ $totalStudents }}
</h3>


<h3>Active Students:
{{ $activeStudents }}
</h3>


<h3>Inactive Students:
{{ $inactiveStudents }}
</h3>


<h3>Average Score:
{{ $averageScore }}
</h3>

</div>

<table border="1" cellpadding="10">

<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Participation Score</th>
    <th>Status</th>
</tr>


@foreach($students as $student)

<tr>

<td>
{{ $student->name }}
</td>


<td>
{{ $student->email }}
</td>


<td>
{{ $student->participation_score }}
</td>


<td>

@if($student->participation_score >= 50)

Active

@elseif($student->participation_score >= 20)

Moderate

@else

Inactive

@endif

</td>

</tr>

@endforeach


</table>


</body>
</html>