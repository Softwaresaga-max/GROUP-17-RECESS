<x-app-sidebar>

<h2>Create Discussion</h2>


<form method="POST" action="{{ route('discussions.store') }}">

@csrf


<input 
type="text"
name="title"
class="form-control mb-3"
placeholder="Discussion title">


<textarea
name="content"
class="form-control mb-3"
placeholder="Write discussion">
</textarea>



<select name="group_id" class="form-control mb-3">

<option value="">
-- Select Discussion Group --
</option>


@foreach($groups as $group)

<option value="{{ $group->id }}">

{{ $group->name }}

</option>

@endforeach


</select>



<button class="btn btn-success">

Post Discussion

</button>


</form>


</x-app-sidebar>