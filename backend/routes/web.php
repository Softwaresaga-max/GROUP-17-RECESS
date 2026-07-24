<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\LecturerDashboardController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\DiscussionReplyController;


/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Dashboard Redirect
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    if (!auth()->check()) {
        return redirect()->route('login');
    }

    if (!auth()->user()->onboarding_completed) {
        return redirect()->route('onboarding');
    }

    return match(auth()->user()->role){

        'admin' => redirect()->route('admin.dashboard'),

        'lecturer' => redirect()->route('lecturer.dashboard'),

        default => redirect()->route('student.dashboard'),

    };

})->middleware('auth')->name('dashboard');



/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

   Route::middleware(['auth','blacklist'])->group(function () {


    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/dashboard',
        [AdminDashboardController::class,'index'])
        ->middleware(['role:admin','onboarding'])
        ->name('admin.dashboard');



    /*
    |--------------------------------------------------------------------------
    | Lecturer Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/lecturer/dashboard',
        [LecturerDashboardController::class,'index'])
        ->middleware('onboarding')
        ->name('lecturer.dashboard');



    /*
    |--------------------------------------------------------------------------
    | Student Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/student/dashboard',
        [StudentDashboardController::class,'index'])
        ->middleware('onboarding')
        ->name('student.dashboard');



    /*
    |--------------------------------------------------------------------------
    | Student Quiz System
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:student')->group(function(){


        Route::get('/student/quizzes',
            [QuizController::class,'index'])
            ->name('student.quizzes');


        Route::get('/student/quiz/{quiz}/start',
            [QuizController::class,'start'])
            ->name('quiz.start');


        Route::post('/student/quiz/{quiz}/submit',
            [QuizController::class,'submit'])
            ->name('quiz.submit');


    });



    /*
    |--------------------------------------------------------------------------
    | Student Materials
    |--------------------------------------------------------------------------
    */

    Route::get('/student/materials',
        [MaterialController::class,'studentMaterials'])
        ->middleware('role:student')
        ->name('student.materials');


    Route::get('/materials/{material}/download',
        [MaterialController::class,'download'])
        ->name('materials.download');



    /*
    |--------------------------------------------------------------------------
    | Student Groups
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:student')->group(function(){


        Route::get('/groups',
            [GroupController::class,'index'])
            ->name('groups.index');


        Route::post('/groups/{group}/join',
            [GroupController::class,'join'])
            ->name('groups.join');


    });



    /*
    |--------------------------------------------------------------------------
    | Discussions
    |--------------------------------------------------------------------------
    */

    Route::resource('discussions', DiscussionController::class);

    Route::get(
    '/discussions/{discussion}/pdf',
    [PdfController::class, 'discussionPdf']
)->name('discussions.pdf');

    Route::post(
    '/discussions/{discussion}/reply',
    [DiscussionReplyController::class, 'store']
)->name('discussion.reply');



    /*
    |--------------------------------------------------------------------------
    | Lecturer Quiz Management
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:lecturer')->group(function(){


        Route::get('/quizzes/create',
            [QuizController::class,'create'])
            ->name('quizzes.create');


        Route::post('/quizzes',
            [QuizController::class,'store'])
            ->name('quizzes.store');


        Route::get('/quizzes/{quiz}/questions',
            [QuizController::class,'questions'])
            ->name('quizzes.questions');


        Route::post('/quizzes/{quiz}/questions',
            [QuizController::class,'storeQuestion'])
            ->name('quizzes.questions.store');


        Route::get('/quizzes/{quiz}/analytics',
            [QuizController::class,'analytics'])
            ->name('quizzes.analytics');


    });



    /*
    |--------------------------------------------------------------------------
    | General Quizzes
    |--------------------------------------------------------------------------
    */

    Route::get('/quizzes',
        [QuizController::class,'index'])
        ->name('quizzes.index');



    /*
    |--------------------------------------------------------------------------
    | Lecturer Reports
    |--------------------------------------------------------------------------
    */

    Route::get('/lecturer/grading',
        [LecturerDashboardController::class,'grading'])
        ->name('lecturer.grading');


    Route::get('/lecturer/analytics',
        [LecturerDashboardController::class,'analytics'])
        ->name('lecturer.analytics');



    /*
    |--------------------------------------------------------------------------
    | Courses
    |--------------------------------------------------------------------------
    */

    Route::get('/courses', function(){

        return view('courses.index');

    })->name('courses.index');



    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', function(){

        return view('profile.index');

    })->name('profile');



    Route::post('/profile/update',
    function(\Illuminate\Http\Request $request){

        $request->validate([

            'name'=>'required|string|max:255',

            'email'=>'required|email|max:255',

        ]);


        $user = auth()->user();


        $user->name = $request->name;

        $user->email = $request->email;

        $user->email_notifications =
        $request->has('email_notifications');


        $user->save();


        return back()->with(
            'success',
            'Profile updated successfully'
        );


    })->name('profile.update');


});



/*
|--------------------------------------------------------------------------
| Onboarding
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function(){


    Route::get('/onboarding',
        [OnboardingController::class,'index'])
        ->name('onboarding');


    Route::post('/onboarding/next',
        [OnboardingController::class,'next'])
        ->name('onboarding.next');


    Route::post('/onboarding/back',
        [OnboardingController::class,'back'])
        ->name('onboarding.back');


    Route::post('/onboarding/complete',
        [OnboardingController::class,'complete'])
        ->name('onboarding.complete');


});



/*
|--------------------------------------------------------------------------
| Admin Management
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:admin'])
->prefix('admin')
->group(function(){

    Route::get('/groups', [GroupController::class, 'index'])
    ->name('admin.groups');

Route::get('/groups/create', [GroupController::class, 'create'])
    ->name('admin.groups.create');

Route::post('/groups', [GroupController::class, 'store'])
    ->name('admin.groups.store');

Route::get('/groups/{group}/edit', [GroupController::class, 'edit'])
    ->name('admin.groups.edit');

Route::put('/groups/{group}', [GroupController::class, 'update'])
    ->name('admin.groups.update');

Route::delete('/groups/{group}', [GroupController::class, 'destroy'])
    ->name('admin.groups.destroy');


    Route::get('/reports',
        [AdminDashboardController::class,'reports'])
        ->name('admin.reports');


    Route::get('/settings',
        [AdminDashboardController::class,'settings'])
        ->name('admin.settings');


    Route::get('/users',
        [UserController::class,'index'])
        ->name('admin.users');


    Route::post('/users/{user}/role',
        [UserController::class,'updateRole'])
        ->name('admin.users.role');


    Route::delete('/users/{user}',
        [UserController::class,'destroy'])
        ->name('admin.users.delete');


});



/*
|--------------------------------------------------------------------------
| Learning Materials
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function(){




    Route::middleware('role:lecturer')->group(function(){


        Route::get('/materials/create',
            [MaterialController::class,'create'])
            ->name('materials.create');


        Route::post('/materials',
            [MaterialController::class,'store'])
            ->name('materials.store');


    });

    Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit'])
    ->name('quizzes.submit');



    Route::get('/materials',
        [MaterialController::class,'index'])
        ->name('materials.index');


});



require __DIR__.'/auth.php';