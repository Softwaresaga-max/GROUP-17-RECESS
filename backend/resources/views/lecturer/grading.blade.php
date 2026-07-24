<x-app-sidebar>

<h2>📋 Student Participation Grading</h2>


<table style="width:100%; background:white; border-collapse:collapse;">

<tr>
<th style="padding:10px;">Student</th>
<th>Discussions</th>
<th>Replies</th>
<th>Quiz Attempts</th>
<th>Total Score</th>
</tr>


@foreach($students as $student)

<tr>

<td style="padding:10px;">
{{ $student->name }}
</td>


<td>
{{ $student->discussions->count() }}
</td>


<td>
{{ $student->discussionReplies->count() }}
</td>


<td>
{{ $student->attempts->count() }}
</td>


<td>
<strong>
{{ $student->participation_score }}
</strong>
</td>


</tr>

@endforeach


</table>


<br>

<a href="{{ route('lecturer.dashboard') }}">
Back to Dashboard
</a>


</x-app-sidebar>