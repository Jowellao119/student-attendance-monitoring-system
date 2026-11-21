<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;

// StudentTrack pages - Login required
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Students
    Route::get('/students', [StudentController::class, 'index'])
        ->name('students.index');

    Route::get('/students/create', function () {
        return view('students.create');
    })->name('students.create');

    Route::post('/students', [StudentController::class, 'store'])
        ->name('students.store');

    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])
        ->name('students.edit');

    Route::put('/students/{student}', [StudentController::class, 'update'])
        ->name('students.update');

    // Attendance
    Route::get('/attendance', [AttendanceController::class, 'index'])
        ->name('attendance.index');

    Route::post('/attendance', [AttendanceController::class, 'store'])
        ->name('attendance.store');

    // Attendance History
    Route::get('/attendance-history', [AttendanceController::class, 'history'])
        ->name('attendance.history');

    // Edit Attendance
    Route::get('/attendance/{attendance}/edit', [AttendanceController::class, 'edit'])
        ->name('attendance.edit');

    Route::put('/attendance/{attendance}', [AttendanceController::class, 'update'])
        ->name('attendance.update');

    Route::delete('/attendance/{attendance}', [AttendanceController::class, 'destroy'])
        ->name('attendance.destroy');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Authentication Routes
require __DIR__.'/auth.php';
