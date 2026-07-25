<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Discussion;
use App\Models\Quiz;

class LecturerDashboardController extends Controller
{

    public function index()
    {
        return view('lecturer.dashboard', [

            'discussions' => Discussion::count(),

            'quizzes' => Quiz::count(),

            'students' => User::where('role','student')->count(),

        ]);
    }



   public function grading()
{

    $students = User::where('role','student')
        ->with([
            'discussions',
            'discussionReplies',
            'attempts.quiz'
        ])
        ->get();


    foreach($students as $student){

        $student->discussion_marks =
            $student->discussions->count() * 5;


        $student->reply_marks =
            $student->discussionReplies->count() * 2;


        $student->quiz_marks =
            $student->attempts->sum('score');


        $student->completed_marks =
            $student->attempts
            ->where('completed', true)
            ->count() * 10;


        $student->participation_score =
            $student->discussion_marks +
            $student->reply_marks +
            $student->quiz_marks +
            $student->completed_marks;

    }


    return view('lecturer.grading',[
        'students'=>$students
    ]);

}
    



    public function analytics()
    {

        return view('lecturer.analytics',[

            'discussions'=>Discussion::count(),

            'quizzes'=>Quiz::count(),

            'students'=>User::where('role','student')->count(),

        ]);

    }

    public function progress()
{
    $students = User::where('role', 'student')
        ->with([
            'course',
            'classRoom',
            'discussions',
            'discussionReplies',
            'attempts'
        ])
        ->get();

    foreach ($students as $student) {

        $student->discussion_count = $student->discussions->count();

        $student->reply_count = $student->discussionReplies->count();

        $student->quiz_attempts = $student->attempts->count();

        $student->average_score = round(
            $student->attempts->avg('score') ?? 0,
            2
        );

        if ($student->average_score >= 80) {

            $student->status = 'Excellent';

        } elseif ($student->average_score >= 60) {

            $student->status = 'Good';

        } elseif ($student->average_score >= 40) {

            $student->status = 'Fair';

        } else {

            $student->status = 'Needs Improvement';

        }

    }

    return view('lecturer.progress', compact('students'));
}

}