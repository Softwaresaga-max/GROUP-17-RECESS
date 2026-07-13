<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;              // ✅ ADD THIS
use Illuminate\Http\Request;

class UserController extends Controller
{

public function assignStudent(Request $request)
{
    $request->validate([
        'user_id' => 'required',
        'class_id' => 'required'
    ]);


    $student = User::find($request->user_id);


    if(!$student){

        return response()->json([
            'message'=>'Student not found'
        ],404);

    }


    $student->class_id = $request->class_id;

    $student->save();



    return response()->json([
        'success'=>true,
        'message'=>'Student assigned successfully'
    ]);

}
    // ---------------- GET ALL USERS ----------------

public function index()
{
    $users = User::select(
        'id',
        'name',
        'email',
        'role',
        'active'
    )->get();


    return response()->json($users);
}

    // ---------------- CREATE USER ----------------
    public function store(Request $request) {
        $user = User::create($request->all());
        return response()->json($user);
    }

    // ---------------- UPDATE USER ----------------
    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user);
    }

    // ---------------- DELETE USER ----------------
    public function destroy($id) {
        User::destroy($id);
        return response()->json(['success' => true]);
    }

    // ---------------- TOGGLE STATUS ----------------
    public function toggleStatus($id) {
        $user = User::findOrFail($id);
        $user->active = !$user->active;
        $user->save();

        return response()->json($user);
    }

    // ---------------- REMOVE STUDENT FROM CLASS ----------------

public function removeStudent(Request $request)
{
    $request->validate([
        'user_id' => 'required'
    ]);


    $student = User::find($request->user_id);


    if(!$student){

        return response()->json([
            'success'=>false,
            'message'=>'Student not found'
        ],404);

    }


    // Remove class assignment
    $student->class_id = null;
    $student->save();


    return response()->json([
        'success'=>true,
        'message'=>'Student removed from class successfully'
    ]);

}
}