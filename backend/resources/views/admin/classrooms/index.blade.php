<x-app-sidebar>

<h2>🏫 Class Rooms Management</h2>


<a href="{{ route('admin.classrooms.create') }}">
➕ Add Class Room
</a>


@if(session('success'))

<p style="color:green">
{{ session('success') }}
</p>

@endif



<table border="1" cellpadding="10">

<tr>

<th>Name</th>
<th>Year</th>
<th>Course</th>
<th>Action</th>

</tr>



@foreach($classRooms as $class)


<tr>

<td>
{{ $class->name }}
</td>


<td>
{{ $class->year }}
</td>


<td>
{{ $class->course->name ?? 'No Course' }}
</td>



<td>

<form method="POST"
action="{{ route('admin.classrooms.destroy',$class) }}">

@csrf
@method('DELETE')


<button type=submit>
Delete
</button>


</form>

</td>


</tr>


@endforeach


</table>


</x-app-sidebar>