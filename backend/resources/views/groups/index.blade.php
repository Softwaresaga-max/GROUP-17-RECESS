<h2>Available Discussion Groups</h2>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif


@foreach($groups as $group)

<div>

    <h3>{{ $group->name }}</h3>

    <p>{{ $group->description }}</p>


    <form method="POST" action="{{ route('groups.join', $group->id) }}">

        @csrf

        <button type="submit">
            Join Group
        </button>

    </form>

</div>

<hr>

@endforeach