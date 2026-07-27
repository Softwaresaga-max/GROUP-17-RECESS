<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'student')
            ->with('activityLogs')
            ->get();

        $totalStudents = $students->count();

        $activeStudents = 0;
        $inactiveStudents = 0;
        $totalScore = 0;

        foreach ($students as $student) {

            $score = 0;

            foreach ($student->activityLogs as $activity) {

                switch ($activity->activity) {

                    case 'Logged in':
                        $score += 1;
                        break;

                    case 'Created a discussion':
                        $score += 5;
                        break;

                    case 'Replied to a discussion':
                        $score += 3;
                        break;

                    case 'Completed a quiz':
                        $score += 5;
                        break;
                }
            }

            $student->participation_score = $score;

            $totalScore += $score;

            if ($score >= 20) {
                $activeStudents++;
            } else {
                $inactiveStudents++;
            }
        }

        $averageScore = $totalStudents > 0
            ? round($totalScore / $totalStudents, 2)
            : 0;


        return view('progress.index', compact(
            'students',
            'totalStudents',
            'activeStudents',
            'inactiveStudents',
            'averageScore'
        ));
    }
}