<?php

use App\Http\Controllers\Api\v1\CategoryController;

Route::get('', [CategoryController::class, 'index'])->name('index');
