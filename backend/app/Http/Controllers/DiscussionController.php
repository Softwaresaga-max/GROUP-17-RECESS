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



        Discussion::create([

            'title' => $request->title,

            'content' => $request->content,

            'category' => 'Academic Discussion',

            'user_id' => Auth::id(),

            'group_id' => $request->group_id,

            'is_active' => true,

            'views' => 0,

        ]);



        return redirect()
            ->route('discussions.index')
            ->with(
                'success',
                'Discussion posted successfully'
            );
    }




    public function show(Discussion $discussion)
    {

        $discussion->increment('views');


        return view(
            'discussions.show',
            compact('discussion')
        );

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