<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function index()
    {
        $courses = Course::latest()->get();

        return view('admin.courses.index', compact('courses'));
    }



    public function create()
    {
        return view('admin.courses.create');
    }



    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'code'=>'required|string|unique:courses,code',
        ]);


        Course::create([
            'name'=>$request->name,
            'code'=>$request->code,
        ]);


        return redirect()
            ->route('admin.courses.index')
            ->with('success','Course created successfully');
    }



    public function destroy(Course $course)
    {
        $course->delete();


        return back()
            ->with('success','Course deleted');
    }

}