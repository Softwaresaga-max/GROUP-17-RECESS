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

public function participationScores()
{
    // Configurable criteria — discussion worth 3 points, reply worth 1 point
    $discussionWeight = 3;
    $postWeight = 1;

    $groups = \App\Models\Group::with('users')->get();

    foreach ($groups as $group) {
        foreach ($group->users as $user) {
            $discussionCount = \App\Models\Discussion::where('user_id', $user->id)
                ->where('group_id', $group->id)
                ->count();

            $discussionIds = \App\Models\Discussion::where('group_id', $group->id)->pluck('id');
            $postCount = \App\Models\Post::where('user_id', $user->id)
                ->whereIn('discussion_id', $discussionIds)
                ->count();

            $score = ($discussionCount * $discussionWeight) + ($postCount * $postWeight);

            \App\Models\ParticipationGrade::updateOrCreate(
                ['user_id' => $user->id, 'group_id' => $group->id],
                [
                    'discussion_count' => $discussionCount,
                    'post_count' => $postCount,
                    'score' => $score,
                    'computed_at' => now(),
                ]
            );
        }
    }

    $grades = \App\Models\ParticipationGrade::with(['user', 'group'])->orderByDesc('score')->get();

    return view('admin.participation-grades', compact('grades'));
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