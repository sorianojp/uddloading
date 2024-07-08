<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SectionController;

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
});


Route::resources([
    'courses' => CourseController::class,
]);
Route::get('courses/{course}/subjects', [SubjectController::class, 'subjects'])->name('subjects');
Route::post('courses/{course}/addSubject', [SubjectController::class, 'addSubject'])->name('addSubject');
Route::get('courses/{course}/sections', [SectionController::class, 'sections'])->name('sections');
Route::post('courses/{course}/addSection', [SectionController::class, 'addSection'])->name('addSection');


require __DIR__.'/auth.php';
