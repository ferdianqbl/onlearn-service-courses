<?php

use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MentorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(MentorController::class)->group(function () {
    Route::get('/mentors', 'index');
    Route::get('/mentors/{id}', 'show');
    Route::post('/mentors', 'create');
    Route::post('/mentors/{id}', 'update');
    Route::delete('/mentors/{id}', 'destroy');
});

Route::controller(CourseController::class)->group(function () {
    Route::get('/courses', 'index');
    Route::get('/courses/{id}', 'show');
    Route::post('/courses', 'create');
    Route::post('/courses/{id}', 'update');
    Route::delete('/courses/{id}', 'destroy');
});

Route::controller(ChapterController::class)->group(function () {
    Route::get('/chapters', 'index');
    Route::get('/chapters/{id}', 'show');
    Route::post('/chapters', 'create');
    Route::post('/chapters/{id}', 'update');
    Route::delete('/chapters/{id}', 'destroy');
});

Route::controller(LessonController::class)->group(function () {
    // Route::get('/lessons', 'index');
    // Route::get('/lessons/{id}', 'show');
    Route::post('/lessons', 'create');
    // Route::post('/lessons/{id}', 'update');
    // Route::delete('/lessons/{id}', 'destroy');
});
