<?php

use Illuminate\Support\Facades\Route;

// Module 1 Controllers
use App\Http\Controllers\ProfileController;

// Module 2 Controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Module 3 Controllers
use App\Http\Controllers\Teacher\QuizController as TeacherController;
use App\Http\Controllers\Student\QuizController as StudentController;

// Module 4 Controllers
use App\Http\Controllers\Module4Controller;

// Module 5 Controllers
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Guest-only authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'show'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'send'])->name('password.email');

    Route::get('/reset-password', [ResetPasswordController::class, 'show'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'update'])->name('password.update');
});

// Logout (auth only)
Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Redirect after login based on role
    Route::get('/index', function () {
        $user = auth()->user();
        if ($user->role === 'teacher') {
            return redirect()->route('dashboards.hometeacher');
        } elseif ($user->role === 'student') {
            return redirect()->route('dashboards.homestudent');
        }
        return redirect('/'); // fallback
    })->name('redirect.after.login');

    /*
    |----------------------------------------------------------------------
    | Dashboard Routes
    |----------------------------------------------------------------------
    */
    Route::get('/dashboards/homestudent', function () {
        return view('dashboards.homestudent'); // dashboards/student.blade.php
    })->name('dashboards.homestudent');

    Route::get('/dashboards/hometeacher', function () {
        return view('dashboards.hometeacher'); // dashboards/teacher.blade.php
    })->name('dashboards.hometeacher');

    /*
    |----------------------------------------------------------------------
    | Student Profile (Module 1)
    |----------------------------------------------------------------------
    */
    Route::get('/student/profile', [ProfileController::class, 'showStudent'])->name('student.profile.show');
    Route::put('/student/profile', [ProfileController::class, 'updateStudent'])->name('student.profile.update');
    Route::put('/student/profile/password', [ProfileController::class, 'updatePasswordStudent'])->name('student.profile.updatePassword');
    Route::delete('/student/profile', [ProfileController::class, 'destroyStudent'])->name('student.profile.destroy');

    /*
    |----------------------------------------------------------------------
    | Teacher Profile (Module 1)
    |----------------------------------------------------------------------
    */
    Route::get('/teacher/profile', [ProfileController::class, 'showTeacher'])->name('teacher.profile.show');
    Route::put('/teacher/profile', [ProfileController::class, 'updateTeacher'])->name('teacher.profile.update');
    Route::put('/teacher/profile/password', [ProfileController::class, 'updatePasswordTeacher'])->name('teacher.profile.updatePassword');
    Route::delete('/teacher/profile', [ProfileController::class, 'destroyTeacher'])->name('teacher.profile.destroy');

    /*
    |----------------------------------------------------------------------
    | Teacher Routes (Module 3)
    |----------------------------------------------------------------------
    */
    Route::prefix('teacher')->name('module3.teacher.')->group(function () {
        Route::get('/index', [TeacherController::class, 'index'])->name('index');
        Route::get('/create', [TeacherController::class, 'create'])->name('create');
        Route::post('/store', [TeacherController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [TeacherController::class, 'edit'])->name('edit');
        Route::patch('/update/{id}', [TeacherController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [TeacherController::class, 'destroy'])->name('delete');
        Route::get('/report/{id}', [TeacherController::class, 'report'])->name('report');

        // Add question to existing quiz
        Route::post('/{quiz_id}/add-question', [TeacherController::class, 'addQuestion'])->name('addQuestion');
    });

    /*
    |----------------------------------------------------------------------
    | Student Routes (Module 3)
    |----------------------------------------------------------------------
    */
    Route::prefix('student')->name('module3.student.')->group(function () {
        Route::get('/index', [StudentController::class, 'index'])->name('index');
        Route::get('/show/{id}', [StudentController::class, 'show'])->name('show');
        Route::post('/submit/{id}', [StudentController::class, 'submit'])->name('submit');
        Route::get('/result/{id}', [StudentController::class, 'result'])->name('result');
        Route::get('/score/{id}', [StudentController::class, 'score'])->name('score');
        Route::get('/allquiz', [StudentController::class, 'allquiz'])->name('allquiz');
    });

    /*
    |----------------------------------------------------------------------
    | Student Routes (Module 4)
    |----------------------------------------------------------------------
    */
    Route::get('/student/dashboard', [Module4Controller::class, 'studentDashboard'])->name('studView.dashboardStud');
    Route::get('/student/subjects', [Module4Controller::class, 'studentSubjects'])->name('student.subjects');
    Route::get('/student/mathematics', [Module4Controller::class, 'studentMath'])->name('student.mathematics');
    
    /*
    |----------------------------------------------------------------------
    | Teacher Routes (Module 4)
    |----------------------------------------------------------------------
    */
    Route::get('/teacher/dashboard', [Module4Controller::class, 'dashboard'])->name('teacherView.dashboard');
    Route::get('/teacher/subjects', [Module4Controller::class, 'subjects'])->name('teacher.subjects');
    Route::get('/teacher/mathematics', [Module4Controller::class, 'mathematics'])->name('teacher.mathematics');

    /*
    |----------------------------------------------------------------------
    | Teacher Announcement Routes (Module 4)
    |----------------------------------------------------------------------
    */
    Route::prefix('teacher')->group(function () {
    Route::post('/announcement', [Module4Controller::class, 'storeAnnouncement'])
        ->name('announcement.store');

    Route::delete('/announcement/{id}', [Module4Controller::class, 'deleteAnnouncement'])
        ->name('announcement.delete');

    // Material routes
    Route::post('/material', [Module4Controller::class, 'storeMaterial'])
         ->name('material.store');

    Route::put('/material/{id}', [Module4Controller::class, 'updateMaterial'])
         ->name('material.update');

    Route::delete('/material/{id}', [Module4Controller::class, 'deleteMaterial'])
         ->name('material.delete');
    });

    /*
    |----------------------------------------------------------------------
    | Discussions & Comments
    |----------------------------------------------------------------------
    */
    // Discussions
    Route::get('/discussions', [DiscussionController::class, 'index'])->name('discussions.index');
    Route::get('/discussions/create', [DiscussionController::class, 'create'])->name('discussions.create');
    Route::post('/discussions', [DiscussionController::class, 'store'])->name('discussions.store');
    Route::get('/discussions/{discussion}', [DiscussionController::class, 'show'])->name('discussions.show');
    Route::get('/discussions/{discussion}/edit', [DiscussionController::class, 'edit'])->name('discussions.edit');
    Route::put('/discussions/{discussion}', [DiscussionController::class, 'update'])->name('discussions.update');
    Route::delete('/discussions/{discussion}', [DiscussionController::class, 'destroy'])->name('discussions.destroy');

    // Comments
    Route::post('/discussions/{discussion}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});
