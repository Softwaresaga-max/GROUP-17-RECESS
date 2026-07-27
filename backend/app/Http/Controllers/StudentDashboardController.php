<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Quiz;

class StudentDashboardController extends Controller
{
   public function index()
{
    $student = auth()->user();

    return view('student.dashboard', [

        'discussions' => Discussion::count(),

        'quizzes' => Quiz::where('status','published')
            ->where('is_active',1)
            ->where('course_id',$student->course_id)
            ->where('class_room_id',$student->class_room_id)
            ->count(),

        'course' => $student->course,

        'classRoom' => $student->classRoom,

    ]);
}
}