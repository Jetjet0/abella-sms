<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ApplicantController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\ScholarshipController;
use App\Http\Controllers\Api\ApplicationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Auth Routes (no token required)
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me',      [AuthController::class, 'me']);
    });
});

/*
|--------------------------------------------------------------------------
| Protected Routes (token required)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // --- Students ---
    Route::get('students',              [StudentController::class, 'index']);
    Route::post('students',             [StudentController::class, 'store']);
    Route::get('students/{student}',    [StudentController::class, 'show']);
    Route::put('students/{student}',    [StudentController::class, 'update']);
    Route::patch('students/{student}',  [StudentController::class, 'update']);
    Route::delete('students/{student}', [StudentController::class, 'destroy']);

    // --- Scholarships ---
    Route::get('scholarships',                  [ScholarshipController::class, 'index']);
    Route::post('scholarships',                 [ScholarshipController::class, 'store']);
    Route::get('scholarships/{scholarship}',    [ScholarshipController::class, 'show']);
    Route::put('scholarships/{scholarship}',    [ScholarshipController::class, 'update']);
    Route::patch('scholarships/{scholarship}',  [ScholarshipController::class, 'update']);
    Route::delete('scholarships/{scholarship}', [ScholarshipController::class, 'destroy']);

    // --- Applications ---
    Route::get('applications',                         [ApplicationController::class, 'index']);
    Route::post('applications',                        [ApplicationController::class, 'store']);
    Route::get('applications/{application}',           [ApplicationController::class, 'show']);
    Route::patch('applications/{application}/approve', [ApplicationController::class, 'approve']);
    Route::patch('applications/{application}/reject',  [ApplicationController::class, 'reject']);

    // --- Applicants ---
    Route::get('applicants',              [ApplicantController::class, 'index']);
    Route::post('applicants',             [ApplicantController::class, 'store']);
    Route::get('applicants/{id}',         [ApplicantController::class, 'show']);
    Route::put('applicants/{id}',         [ApplicantController::class, 'update']);
    Route::patch('applicants/{id}',       [ApplicantController::class, 'update']);
    Route::delete('applicants/{id}',      [ApplicantController::class, 'destroy']);
});