<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\StudentEnrollmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});


//changes
Route::get('/up', fn () => response()->json(['status' => 'ok']));
Route::get('/check', function () {
    $users = \App\Models\User::all(['id', 'name', 'email', 'role']);
    return \response()->json($users->toArray());
});
Route::get('/setup', function () {
    \Artisan::call('migrate', ['--force' => true]);
    \Artisan::call('db:seed', ['--force' => true]);
    return \Artisan::output();
});

//del later
Route::get('/seed-now', function () {
    \Artisan::call('migrate', ['--force' => true]);
    \Artisan::call('db:seed', ['--force' => true]);
    return "Done! Migrations and seeders ran.<br>";
});


////////----///////
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/my-enrollments', [StudentEnrollmentController::class, 'index'])->name('student.enrollments.index');
    Route::post('/my-enrollments', [StudentEnrollmentController::class, 'store'])->name('student.enrollments.store');
    Route::delete('/my-enrollments/{enrollment}', [StudentEnrollmentController::class, 'destroy'])->name('student.enrollments.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin only routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('students', StudentController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('enrollments', EnrollmentController::class);
});

require __DIR__.'/auth.php';
