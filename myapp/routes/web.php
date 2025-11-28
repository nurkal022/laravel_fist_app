<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\AttendancesController;

Route::get('/', function () {
    return redirect()->route('students.index');
});

// Студенты
Route::resource('students', StudentsController::class);

// Посещаемость
Route::get('/attendances/today', [AttendancesController::class, 'today'])->name('attendances.today');
Route::post('/attendances/store', [AttendancesController::class, 'store'])->name('attendances.store');
Route::get('/attendances/report', [AttendancesController::class, 'report'])->name('attendances.report');
Route::get('/attendances/student/{student}', [AttendancesController::class, 'student'])->name('attendances.student');
