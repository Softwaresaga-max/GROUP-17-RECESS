<x-app-sidebar>

<div style="max-width:900px;margin:auto;">

    <h2>📌 Recommended for You</h2>
    <p style="color:gray;">Based on discussions in your groups</p>

    <hr>

    @forelse($recommended as $discussion)
        <div style="padding:15px;border:1px solid #ddd;margin-bottom:10px;border-radius:8px;">
            <strong>{{ $discussion->title }}</strong>
            <p>{{ Str::limit($discussion->content, 100) }}</p>
            <small>Category: {{ $discussion->category ?? 'General' }}</small>
            <br>
            <a href="{{ route('discussions.show', $discussion) }}">Open Discussion</a>
        </div>
    @empty
        <p>No recommendations available yet.</p>
    @endforelse

</div>

</x-app-sidebar>