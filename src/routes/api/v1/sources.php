<?php

use App\Http\Controllers\Api\v1\SourceController;

Route::get('', [SourceController::class, 'index'])->name('index');
