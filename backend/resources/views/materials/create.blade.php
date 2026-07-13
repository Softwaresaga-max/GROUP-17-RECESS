<x-app-sidebar>

<h2>Upload Learning Material</h2>


@if(session('success'))
    <p>{{ session('success') }}</p>
@endif


@if($groups->count() == 0)

<p style="color:red;">
    No discussion groups available. Create groups first.
</p>

@else


<form method="POST"
      action="{{ route('materials.store') }}"
      enctype="multipart/form-data">

@csrf


<label>
    Title
</label>

<br>

<input type="text"
       name="title"
       required>


<br><br>


<label>
    Select Group
</label>

<br>


<select name="group_id" required>

<option value="">
-- Choose Group --
</option>


@foreach($groups as $group)

<option value="{{ $group->id }}">
    {{ $group->name }}
</option>

@endforeach


</select>


<br><br>


<label>
    PDF File
</label>

<br>


<input type="file"
       name="file"
       accept=".pdf"
       required>


<br><br>


<button type="submit">
    Upload PDF
</button>


</form>


@endif


</x-app-sidebar>