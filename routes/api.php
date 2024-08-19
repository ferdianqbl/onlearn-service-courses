<?php

use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\ImageCourseController;
use App\Http\Controllers\MyCourseController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(MentorController::class)->group(function () {
    Route::get('/mentors', 'index');
    Route::get('/mentors/{id}', 'show');
    Route::post('/mentors', 'create');
    Route::put('/mentors/{id}', 'update');
    Route::delete('/mentors/{id}', 'destroy');
});

Route::controller(CourseController::class)->group(function () {
    Route::get('/courses', 'index');
    Route::get('/courses/{id}', 'show');
    Route::post('/courses', 'create');
    Route::put('/courses/{id}', 'update');
    Route::delete('/courses/{id}', 'destroy');
});

Route::controller(ChapterController::class)->group(function () {
    Route::get('/chapters', 'index');
    Route::get('/chapters/{id}', 'show');
    Route::post('/chapters', 'create');
    Route::put('/chapters/{id}', 'update');
    Route::delete('/chapters/{id}', 'destroy');
});

Route::controller(LessonController::class)->group(function () {
    Route::get('/lessons', 'index');
    Route::get('/lessons/{id}', 'show');
    Route::post('/lessons', 'create');
    Route::put('/lessons/{id}', 'update');
    Route::delete('/lessons/{id}', 'destroy');
});

Route::controller(ImageCourseController::class)->group(function () {
    Route::get('/image-courses', 'index');
    Route::get('/image-courses/{id}', 'show');
    Route::post('/image-courses', 'create');
    Route::delete('/image-courses/{id}', 'destroy');
});

Route::controller(MyCourseController::class)->group(function () {
    Route::get('/my-courses', 'index');
    // Route::get('/my-courses/{id}', 'show');
    Route::post('/my-courses', 'create');
    // Route::delete('/my-courses/{id}', 'destroy');
});

Route::controller(ReviewController::class)->group(function () {
    Route::get('/review', 'index');
    // Route::get('/review/{id}', 'show');
    Route::post('/review', 'create');
    Route::put('/review/{id}', 'update');
    // Route::delete('/review/{id}', 'destroy');
});
