<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\JobPostController;
use App\Http\Controllers\Api\JobResponseController;
use App\Http\Controllers\BlogController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/check-auth', [AuthController::class, 'checkAuth']);
});


Route::middleware('auth:sanctum')->prefix('blogs')->group(function () {
    Route::get('/', [BlogController::class, 'index']);
    Route::get('/{id}', [BlogController::class, 'show']);
    Route::post('/add', [BlogController::class, 'store']);
    Route::post('/{id}/update', [BlogController::class, 'update']);
    Route::post('/{id}/status', [BlogController::class, 'updateStatus']);
    Route::post('/{id}/delete', [BlogController::class, 'destroy']);
});

Route::prefix('contact')->group(function () {
    Route::post('/us', [ContactController::class, 'store']);       // POST api/contact/us

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/us-get', [ContactController::class, 'index']);    // GET  api/contact/us-get
        Route::get('/us-get/{id}', [ContactController::class, 'show']); // GET  api/contact/us-get/{id}
        Route::post('/us/{id}/is-read', [ContactController::class, 'updateReadStatus']); // POST api/contact/us/{id}/is-read
    });
});


Route::prefix('job-posts')->group(function () {

    // Public listing: active, non-deleted jobs, newest first
    Route::get('/active', [JobPostController::class, 'activeJobs']); // GET api/job-posts/active

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [JobPostController::class, 'index']);                  // GET    api/job-posts
        Route::post('/add', [JobPostController::class, 'store']);              // POST   api/job-posts/add
        Route::get('/{id}', [JobPostController::class, 'show']);               // GET    api/job-posts/{id}
        Route::post('/{id}/update', [JobPostController::class, 'update']);     // POST   api/job-posts/{id}/update
        Route::post('/{id}/status', [JobPostController::class, 'updateStatus']); // POST api/job-posts/{id}/status
        Route::post('/{id}/delete', [JobPostController::class, 'destroy']);    // POST   api/job-posts/{id}/delete
    });
});

Route::prefix('job-responses')->group(function () {
    // Public: applicants submit their CV / response to a job post.
    Route::post('/add', [JobResponseController::class, 'store']); // POST api/job-responses/add

    // Admin only.
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [JobResponseController::class, 'index']);                    // GET  api/job-responses  (all incl. trashed, ?is_active=1|0)
        Route::get('/{id}', [JobResponseController::class, 'show']);                 // GET  api/job-responses/{id}
        Route::get('/{id}/download-cv', [JobResponseController::class, 'downloadCv']); // GET  api/job-responses/{id}/download-cv
        Route::post('/{id}/status', [JobResponseController::class, 'updateStatus']); // POST api/job-responses/{id}/status
    });
});

Route::get('users/by-category', [BlogController::class, 'byCategory']);
Route::get('/featured', [BlogController::class, 'featured']);
Route::get('users/blogs/{id}', [BlogController::class, 'showbyid']);