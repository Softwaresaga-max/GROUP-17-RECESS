<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\QuizResult;


class QuizController extends Controller
{

    public function index()
    {
        $quizzes = Quiz::all();

        return view('student.quizzes', compact('quizzes'));
    }



    public function start($id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);

        return view('student.start_quiz', compact('quiz'));
    }



    public function submit(Request $request, $id)
    {

        $quiz = Quiz::with('questions')->findOrFail($id);


        $score = 0;


        foreach($quiz->questions as $question)
        {

            if(
                isset($request->answers[$question->id])
                &&
                $request->answers[$question->id] 
                == $question->correct_answer
            )
            {
                $score++;
            }

        }



        QuizResult::create([

            'user_id'=>auth()->id(),

            'quiz_id'=>$quiz->id,

            'score'=>$score,

            'total_questions'=>$quiz->questions->count()

        ]);



        return redirect()
        ->route('student.quizzes')
        ->with(
            'success',
            "Quiz completed. Score: $score/".$quiz->questions->count()
        );

    }

}