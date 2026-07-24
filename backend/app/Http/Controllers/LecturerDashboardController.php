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
                'attempts'
            ])
            ->get();



        foreach($students as $student){


            $student->discussion_marks =
                $student->discussions->count() * 5;


            $student->reply_marks =
                $student->discussionReplies->count() * 2;


            $student->quiz_marks =
                $student->attempts->count() * 5;


            $student->completed_marks =
                $student->attempts
                ->where('completed',true)
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

}