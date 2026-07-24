@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Create Discussion Group</h2>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.groups.store') }}">
        @csrf

        <div>
            <label>Group Name</label><br>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                required>
        </div>

        <br>

        <div>
            <label>Description</label><br>
            <textarea
                name="description"
                rows="5">{{ old('description') }}</textarea>
        </div>

        <br>

        <button type="submit">
            Create Group
        </button>

    </form>

</div>

@endsections