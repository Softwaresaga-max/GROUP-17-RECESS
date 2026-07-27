<x-app-sidebar>

<style>

table{
    width:100%;
    border-collapse:collapse;
    background:white;
}

th{
    background:#2563eb;
    color:white;
    padding:12px;
}

td{
    padding:12px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

tr:hover{
    background:#f5f5f5;
}

.search-box{
    margin-bottom:20px;
}

.search-box input{
    width:300px;
    padding:10px;
    border-radius:8px;
    border:1px solid #ccc;
}

.badge{
    padding:6px 12px;
    border-radius:20px;
    color:white;
    font-size:13px;
    font-weight:bold;
}

.excellent{
    background:#16a34a;
}

.good{
    background:#2563eb;
}

.fair{
    background:#f59e0b;
}

.poor{
    background:#dc2626;
}

</style>


<h2>📈 Student Progress Tracking</h2>

<style>
.summary-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:15px;
    margin:20px 0;
}

.summary-card{
    background:white;
    padding:20px;
    border-radius:12px;
    text-align:center;
    box-shadow:0 4px 10px rgba(0,0,0,.08);
}

.summary-card h3{
    margin:0;
    font-size:30px;
    color:#2563eb;
}

.summary-card p{
    margin-top:8px;
    color:#666;
}
</style>

<div class="summary-grid">

    <div class="summary-card">
        <h3>{{ $students->count() }}</h3>
        <p>Total Students</p>
    </div>

    <div class="summary-card">
        <h3>{{ $students->where('status','Excellent')->count() }}</h3>
        <p>Excellent</p>
    </div>

    <div class="summary-card">
        <h3>{{ $students->where('status','Good')->count() }}</h3>
        <p>Good</p>
    </div>

    <div class="summary-card">
        <h3>{{ $students->where('status','Needs Improvement')->count() }}</h3>
        <p>Needs Improvement</p>
    </div>

</div>

<div class="search-box">

<input
type="text"
id="search"
placeholder="Search student..."
onkeyup="searchStudent()">

</div>


<table id="studentsTable">

<thead>

<tr>

<th>Student</th>

<th>Course</th>

<th>Class</th>

<th>Discussions</th>

<th>Replies</th>

<th>Quiz Attempts</th>

<th>Average Quiz</th>

<th>Status</th>

</tr>

</thead>

<tbody>

@foreach($students as $student)

<tr>

<td>{{ $student->name }}</td>

<td>{{ $student->course->name ?? 'N/A' }}</td>

<td>{{ $student->classRoom->name ?? 'N/A' }}</td>

<td>{{ $student->discussion_count }}</td>

<td>{{ $student->reply_count }}</td>

<td>{{ $student->quiz_attempts }}</td>

<td>{{ $student->average_score }}%</td>

<td>

@if($student->status=='Excellent')

<span class="badge excellent">
Excellent
</span>

@elseif($student->status=='Good')

<span class="badge good">
Good
</span>

@elseif($student->status=='Fair')

<span class="badge fair">
Fair
</span>

@else

<span class="badge poor">
Needs Improvement
</span>

@endif

</td>

</tr>

@endforeach

</tbody>

</table>


<br>

<a href="{{ route('lecturer.dashboard') }}">
← Back to Dashboard
</a>


<script>

function searchStudent(){

let input=document.getElementById("search").value.toLowerCase();

let rows=document.querySelectorAll("#studentsTable tbody tr");

rows.forEach(function(row){

let student=row.cells[0].textContent.toLowerCase();

if(student.includes(input)){

row.style.display="";

}else{

row.style.display="none";

}

});

}

</script>

</x-app-sidebar>