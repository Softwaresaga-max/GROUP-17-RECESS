<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Discussion;
use App\Models\Quiz;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'users' => User::count(),
            'discussions' => Discussion::count(),
            'quizzes' => Quiz::count(),
        ]);
    }

    public function reports()
{
    return view('admin.reports', [
        'users' => User::count(),
        'students' => User::where('role', 'student')->count(),
        'lecturers' => User::where('role', 'lecturer')->count(),
        'admins' => User::where('role', 'admin')->count(),
        'discussions' => Discussion::count(),
        'quizzes' => Quiz::count(),
    ]);
}

public function settings()
{
    return view('admin.settings');
}

public function groupStats()
{
    $groups = \App\Models\Group::withCount(['discussions', 'users'])->get()->map(function ($group) {
        $discussionIds = $group->discussions()->pluck('id');
        $postCount = \App\Models\Post::whereIn('discussion_id', $discussionIds)->count();

        return [
            'name' => $group->name,
            'member_count' => $group->users_count,
            'discussion_count' => $group->discussions_count,
            'post_count' => $postCount,
        ];
    });

    return view('admin.group-stats', compact('groups'));
}

}