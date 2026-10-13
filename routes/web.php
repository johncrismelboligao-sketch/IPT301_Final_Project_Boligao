<?php

use App\Http\Controllers\AttendanceRecordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('students', StudentController::class);
Route::resource('classes', SchoolClassController::class)->parameters(['classes' => 'schoolClass']);
Route::resource('subjects', SubjectController::class);
Route::resource('teachers', TeacherController::class);
Route::resource('attendance', AttendanceRecordController::class)
    ->parameters(['attendance' => 'attendanceRecord'])
    ->except('show');
