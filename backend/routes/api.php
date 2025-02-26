<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Instructor\InstructorCourseController;
use App\Http\Controllers\Instructor\InstructorLectureContentController;
use App\Http\Controllers\Instructor\InstructorLectureController;
use App\Http\Controllers\Instructor\InstructorSectionController;
use Illuminate\Support\Facades\Route;


/*----------------- Auth Routes -----------------*/
Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [RegisterUserController::class, '__invoke']);
    Route::post('/login', [LoginController::class, 'store']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [MeController::class, '__invoke']);
        Route::post('/logout', [LoginController::class, 'destroy']);
        Route::controller(EmailVerificationController::class)->group(function () {
            Route::post('email/verification-notification', 'sendVerificationEmail')->middleware(['throttle:6,1']);
            Route::get('verify-email/{user}/{hash}', 'verify')->name('verification.verify');
        });
    });
});

Route::get('/categories', [CategoryController::class, '__invoke']);
/*----------------- Instructor Routes -----------------*/
Route::scopeBindings()->group(function () {
    Route::group([
        'middleware' => 'auth:sanctum',
        'prefix' => 'instructor',
    ], function () {
        Route::controller(InstructorCourseController::class)->group(function () {
            //Courses  basic info
            Route::get('/courses', 'index');
            Route::post('/courses', 'store');
            Route::get('/courses/{course}', 'show');
            Route::get('/courses/{course}/basic', 'getBasicInfo');
            Route::put('/courses/{course}/basic', 'updateBasicInfo');
            Route::put('/courses/{course}/status', 'updateStatus');
            Route::post('/courses/{course}/cover', 'cover');
            Route::get('/courses/{course}/curriculum', 'curriculum');
        });

        //Course Sections
        Route::controller(InstructorSectionController::class)->group(function () {
            Route::post('/courses/{course}/sections', 'store');
            Route::put('/courses/{course}/sections/{section}', 'update');
            Route::delete('/courses/{course}/sections/{section}', 'destroy');
        });

        //Course Lectures
        Route::controller(InstructorLectureController::class)->group(function () {
            Route::post('/courses/{course}/sections/{section}/lectures', 'store');
            Route::put('/courses/{course}/lectures/{lecture}', 'update');
            Route::delete('/courses/{course}/lectures/{lecture}', 'destroy');
        });

        //Lecture content
        Route::controller(InstructorLectureContentController::class)->group(function () {
            Route::put('/courses/{course}/lectures/{lecture}/article', 'update');
            Route::post('/lectures/{lecture}/chunk', 'upload');
        });
    });
});

