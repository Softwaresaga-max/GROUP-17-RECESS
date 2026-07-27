<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Course;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{

    public function index()
    {
        $classRooms = ClassRoom::with('course')
            ->latest()
            ->get();

        return view('admin.classrooms.index', compact('classRooms'));
    }



    public function create()
    {
        $courses = Course::all();

        return view('admin.classrooms.create', compact('courses'));
    }



    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|string',

            'year' => 'required|string',

            'course_id' => 'required|exists:courses,id',

        ]);



        ClassRoom::create([

            'name' => $request->name,

            'year' => $request->year,

            'course_id' => $request->course_id,

        ]);



        return redirect()
            ->route('admin.classrooms.index')
            ->with('success','Class room created successfully');

    }



  public function destroy($id)
{
    $classRoom = ClassRoom::findOrFail($id);

    $classRoom->delete();

    return back()
        ->with('success','Class room deleted');
}

}