<?php

use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\ReportCardController;
use App\Http\Controllers\TimetableController;
use Illuminate\Support\Facades\Route;

Route::get('/api/health', HealthController::class)->name('api.health');

Route::view('/', 'home')->name('home');
Route::get('/admissions/apply', [AdmissionController::class, 'create'])->name('admissions.create');
Route::post('/admissions/apply', [AdmissionController::class, 'store'])->name('admissions.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/portal', [DashboardController::class, 'index'])->name('portal');
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

    Route::middleware('role:administrator,admissions_officer,teacher,non_teaching_staff,student')->group(function () {
        Route::get('/portal/timetable', [TimetableController::class, 'index'])->name('portal.timetable');
        Route::get('/portal/report-cards', [ReportCardController::class, 'index'])->name('portal.report-cards');
    });

    Route::middleware('role:administrator,admissions_officer,teacher,non_teaching_staff')->group(function () {
        Route::get('/portal/admissions', [AdmissionController::class, 'index'])->name('admissions.index');
        Route::patch('/portal/admissions/{admission}', [AdmissionController::class, 'update'])->name('admissions.update');
        Route::get('/portal/attendance', [AttendanceController::class, 'index'])->name('portal.attendance');
        Route::post('/portal/attendance', [AttendanceController::class, 'store'])->name('portal.attendance.store');
    });
});
