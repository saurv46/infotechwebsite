<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Named "login" route required by Laravel's auth middleware: when an
// unauthenticated request hits a protected route, the middleware redirects
// here. As this is an API, return a clean JSON 401 instead of an HTML page,
// which also stops the "Route [login] not defined" RouteNotFoundException.
Route::get('/login', function () {
    return response()->json([
        'status'  => false,
        'message' => 'Unauthenticated. Please pass a valid access token.',
    ], 401);
})->name('login');
