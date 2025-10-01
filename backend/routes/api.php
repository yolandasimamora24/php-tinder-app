<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SwipeController;
use App\Http\Controllers\LikeController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/potential-matches', [SwipeController::class, 'potentialMatches']);
    Route::post('/swipe', [SwipeController::class, 'swipe']);
    Route::get('/liked-users', [LikeController::class, 'likedUsers']);
});
