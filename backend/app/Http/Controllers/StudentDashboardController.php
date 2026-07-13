<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Quiz;

class StudentDashboardController extends Controller
{
    public function index()
    {
        return view('student.dashboard', [
            'discussions' => Discussion::count(),
            'quizzes' => Quiz::count(),
        ]);
    }
}