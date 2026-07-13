<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class StudentController extends Controller
{

    // GET ALL STUDENTS

    public function index()
    {

        $students = User::where(
            'role',
            'student'
        )->get([
            'id',
            'name',
            'email',
            'role',
            'class_id'
        ]);


        return response()->json(
            $students
        );

    }

}