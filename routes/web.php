<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CounselingController;
use App\Http\Controllers\CounselingNoteController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return inertia('Dashboard');
    })->name('dashboard');

    // Classes & Students only for admins and wali_kelas
    Route::middleware(['role:admin, wali_kelas'])->group(function () {
        Route::resource('classes', ClassRoomController::class)->names('classes');
        Route::resource('students', StudentController::class)->names('students');
    });

    // Attendance: wali_kelas & admin
    Route::post('/attendance/bulk', [AttendanceController::class, 'storeBulk'])->name('attendance.storeBulk')->middleware('role:admin, wali_kelas');
    Route::get('/attendance/{classroom?}', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/create', function () { return inertia('Attendance/Create', ['classes' => \App\Models\ClassRoom::all()]); })->name('attendance.create')->middleware('role:admin, wali_kelas');

    // Counseling: guru_bk and admin can create; others can view limited
    Route::resource('counseling', CounselingController::class)->only(['index','create','store','show'])->names('counseling');

    // Counseling notes
    Route::post('/counseling/{session}/notes', [CounselingNoteController::class, 'store'])->name('counseling.notes.store');
});

// API route used by attendance create page to fetch students
Route::get('/api/classrooms/{classroom}/students', function (\App\Models\ClassRoom $classroom) {
    return $classroom->students()->get();
});
