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
}