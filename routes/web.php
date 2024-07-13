<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\FacultyController;

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



    Route::resources([
        'courses' => CourseController::class,
        'rooms' => RoomController::class,
        'faculties' => FacultyController::class,
        'schedules' => ScheduleController::class,
    ]);
    Route::get('courses/{course}/subjects', [SubjectController::class, 'subjects'])->name('subjects');
    Route::post('courses/{course}/addSubject', [SubjectController::class, 'addSubject'])->name('addSubject');
    Route::get('courses/{course}/sections', [SectionController::class, 'sections'])->name('sections');
    Route::post('courses/{course}/addSection', [SectionController::class, 'addSection'])->name('addSection');


    Route::get('sections/{section}/schedules', [ScheduleController::class, 'sectionSchedules'])->name('sectionSchedules');
    Route::get('faculties/{faculty}/schedules', [ScheduleController::class, 'facultySchedules'])->name('facultySchedules');
    Route::get('rooms/{room}/schedules', [ScheduleController::class, 'roomSchedules'])->name('roomSchedules');

    Route::post('sections/{section}/addSectionSchedule', [ScheduleController::class, 'addSectionSchedule'])->name('addSectionSchedule');
    Route::post('faculties/{faculty}/addFacultySchedule', [ScheduleController::class, 'addFacultySchedule'])->name('addFacultySchedule');
    Route::post('rooms/{room}/addRoomSchedule', [ScheduleController::class, 'addRoomSchedule'])->name('addRoomSchedule');

});

require __DIR__.'/auth.php';
