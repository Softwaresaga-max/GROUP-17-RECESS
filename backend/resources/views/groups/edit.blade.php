@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Edit Discussion Group</h2>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('admin.groups.update', $group->id) }}">

        @csrf
        @method('PUT')

        <div>
            <label>Group Name</label><br>

            <input
                type="text"
                name="name"
                value="{{ old('name', $group->name) }}"
                required>

        </div>

        <br>

        <div>

            <label>Description</label><br>

            <textarea
                name="description"
                rows="5">{{ old('description', $group->description) }}</textarea>

        </div>

        <br>

        <button type="submit">
            Update Group
        </button>

    </form>

</div>

@endsection