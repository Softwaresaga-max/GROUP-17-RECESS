<x-app-sidebar>

<h2>Edit Discussion</h2>

<form method="POST" action="{{ route('discussions.update', $discussion->id) }}">
    @csrf
    @method('PUT')

    <input type="text" name="title" value="{{ $discussion->title }}"><br><br>

    <textarea name="content">{{ $discussion->content }}</textarea><br><br>

    <button type="submit">Update</button>
</form>

</x-app-sidebar>