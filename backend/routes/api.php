<?php

use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| PUBLIC API ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/test-api', function () {

    return response()->json([
        'ok' => true
    ]);

});



Route::post('/login', function (Request $request) {


    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);



    if (!Auth::attempt($request->only('email','password'))) {

        return response()->json([
            'message'=>'Invalid credentials'
        ],401);

    }



    $user = Auth::user();



    $token = $user->createToken(
        'educonnect-token'
    )->plainTextToken;



    return response()->json([

        'status'=>'success',

        'user'=>[
            'id'=>$user->id,
            'name'=>$user->name,
            'role'=>$user->role,
        ],

        'token'=>$token

    ]);

});




/*
|--------------------------------------------------------------------------
| PROTECTED API ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {



    /*
    |--------------------------------------------------------------------------
    | USERS
    |--------------------------------------------------------------------------
    */


    Route::get(
        '/users',
        [UserController::class,'index']
    );


    Route::post(
        '/users',
        [UserController::class,'store']
    );


    Route::put(
        '/users/{id}',
        [UserController::class,'update']
    );


    Route::delete(
        '/users/{id}',
        [UserController::class,'destroy']
    );


    Route::patch(
        '/users/{id}/toggle',
        [UserController::class,'toggleStatus']
    );




    /*
    |--------------------------------------------------------------------------
    | STUDENTS
    |--------------------------------------------------------------------------
    */


    Route::get(
        '/students',
        [StudentController::class,'index']
    );



    Route::post(
        '/assign-student',
        [UserController::class,'assignStudent']
    );



    Route::post(
        '/remove-student',
        [UserController::class,'removeStudent']
    );





    /*
    |--------------------------------------------------------------------------
    | EXTRA
    |--------------------------------------------------------------------------
    */


    Route::get('/me', function(Request $request){

        return $request->user();

    });



    Route::get('/dashboard-data', function(){

        return response()->json([
            'message'=>'Secure data for JavaFX'
        ]);

    });



});