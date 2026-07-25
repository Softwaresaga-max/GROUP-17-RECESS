<x-app-sidebar>

<h2>🏫 Create Class Room</h2>


<form method="POST"
action="{{ route('admin.classrooms.store') }}">

@csrf


<label>
Class Name
</label>

<br>

<input type="text"
name="name"
placeholder="Example: BIT 2A">


<br><br>


<label>
Year
</label>

<br>

<input type="text"
name="year"
placeholder="Example: Year 2">


<br><br>



<label>
Select Course
</label>

<br>


<select name="course_id" required>


<option value="">
-- Choose Course --
</option>


@foreach($courses as $course)

<option value="{{ $course->id }}">

{{ $course->name }}

</option>


@endforeach


</select>



<br><br>


<button>
Save Class Room
</button>


</form>


</x-app-sidebar>