<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();
        return view('student.groups.index', compact('groups'));
    }

    public function join(Group $group)
    {
        Auth::user()->groups()->attach($group->id);

        return back()->with('success', 'Joined successfully');
    }
}
