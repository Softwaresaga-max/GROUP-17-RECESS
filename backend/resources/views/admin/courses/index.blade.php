<x-app-sidebar>

<h2>📚 Courses Management</h2>


<a href="{{ route('admin.courses.create') }}">
➕ Add Course
</a>


@if(session('success'))
<p style="color:green">
{{ session('success') }}
</p>
@endif



<table border="1" cellpadding="10">

<tr>
<th>Name</th>
<th>Code</th>
<th>Action</th>
</tr>


@foreach($courses as $course)

<tr>

<td>
{{ $course->name }}
</td>


<td>
{{ $course->code }}
</td>


<td>

<form method="POST"
action="{{ route('admin.courses.destroy',$course) }}">

@csrf
@method('DELETE')

<button>
Delete
</button>

</form>

</td>

</tr>

@endforeach


</table>


</x-app-sidebar>