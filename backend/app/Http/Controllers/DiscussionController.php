<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{

    public function index()
    {
        $discussions = Discussion::with(['user','group'])
            ->latest()
            ->get();

        return view('discussions.index', compact('discussions'));
    }



    public function create()
    {
        $groups = Auth::user()
            ->groups()
            ->get();

        return view('discussions.create', compact('groups'));
    }

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'group_id' => 'required|exists:groups,id',
    ]);

    $recentDuplicate = Discussion::where('user_id', Auth::id())
    ->where('title', $request->title)
    ->where('created_at', '>=', now()->subMinutes(5))
    ->exists();

if ($recentDuplicate) {
    return redirect()->route('discussions.index')
        ->with('error', 'You already posted a discussion with this title recently.');
}

    $category = 'General';
    try {
        $response = \Illuminate\Support\Facades\Http::timeout(3)->post('http://127.0.0.1:5001/classify', [
            'title' => $request->title,
            'content' => $request->content,
        ]);
        if ($response->successful()) {
            $category = $response->json('category');
        }
    } catch (\Exception $e) {
        // ML service unreachable — fall back to General, don't block posting
    }

    $discussion = Discussion::create([
        'title' => $request->title,
        'content' => $request->content,
        'category' => $category,
        'user_id' => Auth::id(),
        'group_id' => $request->group_id,
        'is_active' => true,
        'views' => 0,
    ]);

    \App\Models\ActivityLog::create([
        'user_id' => auth()->id(),
        'activity' => 'Created a discussion',
        'performed_at' => now(),
    ]);

    $interestedUserIds = Discussion::where('category', $category)
        ->where('user_id', '!=', Auth::id())
        ->pluck('user_id')
        ->unique();

    foreach ($interestedUserIds as $userId) {
        \App\Models\Notification::create([
            'user_id' => $userId,
            'type' => 'recommendation',
            'discussion_id' => $discussion->id,
            'message' => "New discussion in {$category}: \"{$discussion->title}\"",
        ]);
    }

    return redirect()
        ->route('discussions.index')
        ->with('success', 'Discussion posted successfully');
}

    
public function show(Discussion $discussion)
{
    $discussion->increment('views');

    $userId = auth()->id();

    $visiblePosts = $discussion->posts()
        ->with('user')
        ->whereDoesntHave('excludedUsers', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
        ->latest()
        ->get();

    return view('discussions.show', compact('discussion', 'visiblePosts'));
}

    public function edit(Discussion $discussion)
    {
        $groups = Auth::user()
            ->groups()
            ->get();

        return view(
            'discussions.edit',
            compact(
                'discussion',
                'groups'
            )
        );
    }




    public function update(Request $request, Discussion $discussion)
    {

        $request->validate([

            'title'=>'required',

            'content'=>'required',

            'group_id'=>'required|exists:groups,id',

        ]);



        $discussion->update([

            'title'=>$request->title,

            'content'=>$request->content,

            'group_id'=>$request->group_id,

        ]);



        return redirect()
            ->route('discussions.index')
            ->with(
                'success',
                'Discussion updated'
            );

    }




    public function destroy(Discussion $discussion)
    {

        $discussion->delete();


        return redirect()
            ->route('discussions.index')
            ->with(
                'success',
                'Discussion deleted'
            );

    }




    public function recommendations()
    {

        $user = Auth::user();


        $groupIds = $user->groups()
            ->pluck('groups.id');


        $recommended = Discussion::whereIn(
                'group_id',
                $groupIds
            )
            ->latest()
            ->take(5)
            ->get();



        return view(
            'discussions.recommendations',
            compact('recommended')
        );

    }

}