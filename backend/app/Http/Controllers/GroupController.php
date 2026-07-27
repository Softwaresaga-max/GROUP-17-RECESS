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

    $joinedGroups = [];

    if (Auth::check()) {
        $joinedGroups = Auth::user()
            ->groups()
            ->pluck('groups.id')
            ->toArray();
    }

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

/**
 * Admin - Show create group form
 */
public function create()
{
    return view('groups.create');
}

/**
 * Admin - Save new group
 */
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:groups,name',
        'description' => 'nullable|string'
    ]);

    Group::create([
        'name' => $request->name,
        'description' => $request->description
    ]);

    return redirect()
    ->route('admin.groups')
    ->with('success', 'Group created successfully.');
}
/**
 * Admin - Show edit form
 */
public function edit(Group $group)
{
    return view('groups.edit', compact('group'));
}

/**
 * Admin - Update group
 */
public function update(Request $request, Group $group)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:groups,name,' . $group->id,
        'description' => 'nullable|string'
    ]);

    $group->update([
        'name' => $request->name,
        'description' => $request->description
    ]);

    return redirect()
        ->route('groups.index')
        ->with('success', 'Group updated successfully.');
}

/**
 * Admin - Delete group
 */
public function destroy(Group $group)
{
    $group->delete();

    return redirect()
        ->route('groups.index')
        ->with('success', 'Group deleted successfully.');
}

}