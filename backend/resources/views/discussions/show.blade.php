<x-app-sidebar>

<h2>{{ $discussion->title }}</h2>

<p>{{ $discussion->content }}</p>

<small>Author: {{ $discussion->user->name ?? 'Unknown' }}</small>

</x-app-sidebar>