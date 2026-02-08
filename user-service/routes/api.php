<?php

use App\Http\Controllers\AddUserProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/profile', [UserController::class, 'profile'])->middleware('auth.verification');
Route::post('/profile/add', AddUserProfileController::class);
