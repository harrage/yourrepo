<?php

use App\Http\Controllers\Api\v1\UserController;

Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])
    ->middleware('auth:sanctum')
    ->name('logout');

Route::put('preferences', [UserController::class, 'updateUserPreferences'])
    ->middleware('auth:sanctum')
    ->name('update-user-preferences');
