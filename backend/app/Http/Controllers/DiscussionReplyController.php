<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\DiscussionReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionReplyController extends Controller
{
    public function store(Request $request, Discussion $discussion)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        DiscussionReply::create([
            'discussion_id' => $discussion->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);


        \App\Models\ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Replied to a discussion',
            'performed_at' => now(),
        ]);


        return back()->with('success', 'Reply posted successfully.');
    }
}