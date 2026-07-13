<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\ClassRoom;

class QuizController extends Controller
{

    /**
     * Lecturer view own quizzes
     * Students view published quizzes
     */
    public function index()
{
    if (Auth::user()->role == 'lecturer') {

        $quizzes = Quiz::where('user_id', Auth::id())
            ->with('questions')
            ->latest()
            ->get();

        return view('quizzes.index', compact('quizzes'));

    }


    // Students see only their assigned quizzes

    $quizzes = Quiz::where('status', 'published')
        ->where('is_active', 1)
        ->where('course_id', Auth::user()->course_id)
        ->where('class_room_id', Auth::user()->class_room_id)
        ->latest()
        ->get();


    return view('student.quizzes', compact('quizzes'));
}


    /**
     * Show quiz questions for lecturer
     */
    public function questions(Quiz $quiz)
    {
        $quiz->load('questions');
        return view('quizzes.questions', compact('quiz'));
    }



    /**
     * Lecturer adds questions
     */
    public function storeQuestion(Request $request, Quiz $quiz)
    {
        $request->validate([
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D',
            'marks' => 'required|integer|min:1',
        ]);

        Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => $request->question_text,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'correct_answer' => $request->correct_answer,
            'marks' => $request->marks,
        ]);

        return redirect()
            ->route('quizzes.questions', $quiz)
            ->with('success', 'Question added successfully');
    }



    /**
 * Create quiz page
 */
public function create()
{
    $courses = \App\Models\Course::all();

    $classes = \App\Models\ClassRoom::all();

    return view('quizzes.create', compact('courses', 'classes'));
}



    /**
     * Store quiz
     */
    public function store(Request $request)
    {
        $request->validate([

    'title' => 'required|string|max:255',

    'description' => 'nullable|string',

    'start_datetime' => 'required|date',

    'end_datetime' => 'required|date|after:start_datetime',

    'course_id' => 'required|exists:courses,id',

    'class_room_id' => 'required|exists:class_rooms,id',

]);

        Quiz::create([

    'title' => $request->title,

    'description' => $request->description,

    'start_datetime' => $request->start_datetime,

    'end_datetime' => $request->end_datetime,

    'course_id' => $request->course_id,

    'class_room_id' => $request->class_room_id,

    'status' => 'published',

    'user_id' => Auth::id(),

    'is_active' => true,

]);

        return redirect()
            ->route('quizzes.index')
            ->with('success', 'Quiz created successfully');
    }



    /**
     * Student starts quiz
     */
    public function start(Quiz $quiz)
    {
        // Check if quiz time is set
        if (!$quiz->start_datetime || !$quiz->end_datetime) {
            return redirect()->route('student.quizzes')
                ->with('error', 'Quiz time not configured.');
        }

        // Not started
        if (now()->lt($quiz->start_datetime)) {
            return redirect()->route('student.quizzes')
                ->with('error', 'Quiz not started yet.');
        }

        // Expired
        if (now()->gt($quiz->end_datetime)) {
            return redirect()->route('student.quizzes')
                ->with('error', 'Quiz expired.');
        }

        // Check attempt
        $existingAttempt = Attempt::where('user_id', Auth::id())
            ->where('quiz_id', $quiz->id)
            ->first();

        // Already completed → show result
        if ($existingAttempt && $existingAttempt->completed) {
            return view('student.result', [
                'quiz' => $quiz,
                'attempt' => $existingAttempt
            ]);
        }

        // Create attempt if not exists
        $attempt = $existingAttempt ?? Attempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'completed' => false,
            'score' => 0,
        ]);

        $quiz->load('questions');

        return view('student.quiz', compact('quiz', 'attempt'));
    }



    /**
     * Student submits quiz
     */
    public function submit(Request $request, Quiz $quiz)
    {
        $attempt = Attempt::findOrFail($request->attempt_id);

        // Prevent resubmission
        if ($attempt->completed) {
            return redirect()->route('student.quizzes')
                ->with('error', 'Already submitted.');
        }

        // Prevent late submission
        if (now()->gt($quiz->end_datetime)) {
            return redirect()->route('student.quizzes')
                ->with('error', 'Time expired. Submission not allowed.');
        }

        $score = 0;

        foreach ($quiz->questions as $question) {
            if (
                isset($request->answers[$question->id]) &&
                $request->answers[$question->id] == $question->correct_answer
            ) {
                $score += $question->marks;
            }
        }

        $attempt->update([
            'score' => $score,
            'completed' => true,
        ]);

        return view('student.result', [
            'quiz' => $quiz,
            'attempt' => $attempt
        ]);
    }



    /**
     * Lecturer analytics
     */
    public function analytics(Quiz $quiz)
    {
        $attempts = $quiz->attempts()->with('user')->get();

        $totalStudents = $attempts->count();
        $averageScore = $attempts->avg('score');

        return view('lecturer.quiz.analytics', compact(
            'quiz',
            'attempts',
            'totalStudents',
            'averageScore'
        ));
    }

}