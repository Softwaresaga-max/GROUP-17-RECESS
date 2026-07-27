<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Attempt;

class StudentResultController extends Controller
{

    public function index()
    {
        $results = Attempt::where('user_id', Auth::id())
            ->where('completed', true)
            ->with('quiz')
            ->latest()
            ->get();


        return view('student.results', compact('results'));
    }

}