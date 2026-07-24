<x-app-sidebar>

<div style="max-width:900px;margin:auto;">

    <h2>{{ $discussion->title }}</h2>

    <p>{{ $discussion->content }}</p>

    <p>
        <strong>Author:</strong>
        {{ $discussion->user->name ?? 'Unknown' }}
    </p>

    <p>
        <strong>Views:</strong>
        {{ $discussion->views }}
    </p>

    <a href="{{ route('discussions.pdf', $discussion->id) }}"
       class="btn btn-danger">
        Export PDF
    </a>

    <hr>

    <h3>Replies</h3>

    @forelse($discussion->replies as $reply)

        <div style="padding:15px;border:1px solid #ddd;margin-bottom:10px;border-radius:8px;">

            <strong>{{ $reply->user->name }}</strong>

            <br><br>

            {{ $reply->content }}

            <br><br>

            <small>
                {{ $reply->created_at->diffForHumans() }}
            </small>

        </div>

    @empty

        <p>No replies yet.</p>

    @endforelse

    <hr>

    <h3>Write a Reply</h3>

    <form method="POST"
          action="{{ route('discussion.reply', $discussion) }}">

        @csrf

        <textarea
            name="content"
            rows="5"
            style="width:100%;padding:10px;"
            placeholder="Write your reply..."
            required></textarea>

        <br><br>

        <button type="submit">
            Post Reply
        </button>

    </form>

</div>

</x-app-sidebar>