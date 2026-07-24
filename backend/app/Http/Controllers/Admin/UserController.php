<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // ✅ GET ALL USERS
  public function index()
{
    $users = User::latest()->get();

    return view('admin.users', compact('users'));
}

    // ✅ CREATE USER
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,lecturer,student'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    // ✅ DELETE USER
public function destroy(User $user)
{
    $user->delete();

    return redirect()
        ->route('admin.users')
        ->with('success', 'User deleted successfully.');
}

    // ✅ 🔥 ASSIGN STUDENT TO CLASS
public function assignStudent(Request $request)
{
    $request->validate([
        'user_id' => 'required',
        'class_id' => 'required'
    ]);


    $user = User::find($request->user_id);


    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'User not found'
        ], 404);
    }


    // 🔥 UPDATE CLASS ID
    $user->class_id = $request->class_id;
    $user->save();


    return response()->json([
        'status' => 'success',
        'message' => 'Student assigned successfully',
        'data' => $user
    ]);
}

public function updateRole(Request $request, User $user)
{
    $request->validate([
        'role' => 'required|in:admin,lecturer,student',
    ]);

    $user->update([
        'role' => $request->role,
    ]);

    return redirect()
        ->route('admin.users')
        ->with('success', 'User role updated successfully.');
}

}