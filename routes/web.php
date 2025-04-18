<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherUserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ParentModelController;
use App\Http\Controllers\AnnouncementController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('teachers', [TeacherUserController::class, 'index'])->name('teachers.index');
    Route::get('students', [StudentController::class, 'index'])->name('students.index');
    Route::get('parents', [ParentModelController::class, 'index'])->name('parents.index');
});
// Route::resource('teachers', TeacherUserController::class);
// Route::resource('students', StudentController::class);
// Route::resource('parents', ParentModelController::class);
// Route::resource('announcements', AnnouncementController::class);



Route::group(['middleware' => ['role:admin']], function () {
    Route::resource('teachers', TeacherUserController::class)->except(['index']);
});

Route::group(['middleware' => ['role:teacher']], function () {
    Route::resource('students', StudentController::class)->except(['index']);
    Route::resource('parents', ParentModelController::class)->except(['index']);
});
Route::group(['middleware' => ['role:admin|teacher']], function () {
    Route::resource('announcements', AnnouncementController::class);
});


require __DIR__.'/auth.php';
