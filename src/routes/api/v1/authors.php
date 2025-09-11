<?php

use App\Http\Controllers\Api\v1\AuthorController;

Route::get('', [AuthorController::class, 'index'])->name('index');
