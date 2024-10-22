<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Middleware\IsAdmin;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:api', IsAdmin::class])->group(function(){
    Route::get('view_not_approved_reviews', [MovieController::class, 'view_not_approved_reviews']);
    Route::post('approve_review', [MovieController::class, 'approve_review']);
});

Route::middleware('auth:api')->group(function() {
    Route::get('view_movies_reviews', [MovieController::class, 'view_movies_reviews']);
    Route::get('search_movies', [MovieController::class, 'search_movies']);
    Route::post('post_review', [MovieController::class, 'post_review']);
});