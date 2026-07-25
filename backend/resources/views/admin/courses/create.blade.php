<x-app-sidebar>

<h2>➕ Create Course</h2>


<form method="POST"
action="{{ route('admin.courses.store') }}">

@csrf


<label>
Course Name
</label>

<br>

<input type="text"
name="name">


<br><br>


<label>
Course Code
</label>

<br>

<input type="text"
name="code">


<br><br>


<button>
Save Course
</button>


</form>


</x-app-sidebar>