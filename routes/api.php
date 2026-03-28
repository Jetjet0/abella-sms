<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ApplicantController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\ScholarshipController;
use App\Http\Controllers\Api\ApplicationController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me',      [AuthController::class, 'me']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('students',     StudentController::class);
    Route::apiResource('scholarships', ScholarshipController::class);

    Route::get('/applications',                         [ApplicationController::class, 'index']);
    Route::post('/applications',                        [ApplicationController::class, 'store']);
    Route::get('/applications/{application}',           [ApplicationController::class, 'show']);
    Route::patch('/applications/{application}/approve', [ApplicationController::class, 'approve']);
    Route::patch('/applications/{application}/reject',  [ApplicationController::class, 'reject']);
    Route::get('applicants', [App\Http\Controllers\Api\ApplicantController::class, 'index']);
    Route::post('applicants', [ApplicantController::class, 'store']);
    Route::get('applicants/{id}', [App\Http\Controllers\Api\ApplicantController::class, 'show']);
    Route::post('applicants', [ApplicantController::class, 'store']);
    
});