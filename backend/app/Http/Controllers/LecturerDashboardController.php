<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Quiz;

class LecturerDashboardController extends Controller
{
    public function index()
    {
        return view('lecturer.dashboard', [
            'discussions' => Discussion::count(),
            'quizzes' => Quiz::count(),
        ]);
    }


    public function grading()
{
    return view('lecturer.grading', [
        'discussions' => Discussion::with('user')->latest()->get(),
        'quizzes' => Quiz::with('user')->latest()->get(),
    ]);
}

public function analytics()
{
    return view('lecturer.analytics', [
        'discussions' => Discussion::count(),
        'quizzes' => Quiz::count(),
    ]);
}
}