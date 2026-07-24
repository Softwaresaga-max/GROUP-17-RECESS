<x-app-sidebar>

<h2>{{ $discussion->title }}</h2>

<p>{{ $discussion->content }}</p>

<small>Author: {{ $discussion->user->name ?? 'Unknown' }}</small>

<a href="{{ route('discussions.pdf',$discussion->id) }}"
   class="btn btn-danger">
    Export PDF
</a>

</x-app-sidebar>