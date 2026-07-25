<?php
namespace App\Http\Controllers;
use App\Models\Discussion;
use App\Models\Post;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{
    public function store(Request $request, Discussion $discussion)
    {
        $request->validate([
            'content' => 'required|string',
            'excluded_user_ids' => 'array',
            'excluded_user_ids.*' => 'exists:users,id',
        ]);

        $post = Post::create([
            'discussion_id' => $discussion->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        if ($request->filled('excluded_user_ids')) {
            $post->excludedUsers()->attach($request->excluded_user_ids);
        }

        if ($discussion->user_id !== Auth::id()) {
            Notification::create([
                'user_id' => $discussion->user_id,
                'type' => 'reply',
                'discussion_id' => $discussion->id,
                'message' => Auth::user()->name . ' replied to your discussion "' . $discussion->title . '"',
            ]);
        }

        return back()->with('success', 'Reply posted');
    }
}