<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\JobPostController;
use App\Http\Controllers\Api\JobResponseController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\BlogController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/check-auth', [AuthController::class, 'checkAuth']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
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
    Route::post('/us', [ContactController::class, 'store']);      
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/us-get', [ContactController::class, 'index']);    
        Route::get('/us-get/{id}', [ContactController::class, 'show']); 
        Route::post('/us/{id}/is-read', [ContactController::class, 'updateReadStatus']); 
    });
});


Route::prefix('job-posts')->group(function () {
    Route::get('/active', [JobPostController::class, 'activeJobs']); 
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [JobPostController::class, 'index']);      
        Route::post('/add', [JobPostController::class, 'store']);      
        Route::get('/{id}', [JobPostController::class, 'show']);        
        Route::post('/{id}/update', [JobPostController::class, 'update']);     
        Route::post('/{id}/status', [JobPostController::class, 'updateStatus']);
        Route::post('/{id}/delete', [JobPostController::class, 'destroy']);    
    });
});

Route::prefix('job-responses')->group(function () {
    Route::post('/add', [JobResponseController::class, 'store']); 

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [JobResponseController::class, 'index']);                   
        Route::get('/{id}', [JobResponseController::class, 'show']);                 
        Route::get('/{id}/download-cv', [JobResponseController::class, 'downloadCv']); 
        Route::post('/{id}/status', [JobResponseController::class, 'updateStatus']); 
    });
});

Route::get('users/by-category', [BlogController::class, 'byCategory']);
Route::get('/featured', [BlogController::class, 'featured']);
Route::get('users/blogs/{slug}', [BlogController::class, 'showBySlug']);


Route::middleware('auth:sanctum')->prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/add', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::post('/{id}/update', [UserController::class, 'update']);
    Route::post('/{id}/delete', [UserController::class, 'destroy']);
});