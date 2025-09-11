<?php

use App\Http\Controllers\Api\v1\ArticleController;

Route::get('', [ArticleController::class, 'index'])->name('index');

Route::get('feed', [ArticleController::class, 'feed'])
    ->middleware('auth:sanctum')
    ->name('feed');
