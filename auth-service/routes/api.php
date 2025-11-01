<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user/{id}', [ProfileController::class, 'show']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [ProfileController::class, 'profile']);
    Route::put('/me', [ProfileController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/test', [ProfileController::class, 'test']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});
