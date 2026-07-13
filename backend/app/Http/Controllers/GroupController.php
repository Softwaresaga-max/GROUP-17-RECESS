<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{

    /**
     * Display available groups for students
     */
    public function index()
{
    $groups = Group::latest()->get();

    $joinedGroups = Auth::user()
        ->groups()
        ->pluck('groups.id')
        ->toArray();

    return view('groups.index', compact(
        'groups',
        'joinedGroups'
    ));
}



    /**
     * Student joins a group
     */
    public function join(Group $group)
    {

        $user = Auth::user();


        // Prevent duplicate joining
        if (!$user->groups()->where('group_id',$group->id)->exists()) {

            $user->groups()->attach($group->id);

        }


        return back()
            ->with(
                'success',
                'You joined the group successfully'
            );
    }

}