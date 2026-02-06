<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InternalRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/internal', InternalRequestController::class)->middleware(['auth:sanctum','internal.auth']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
});

