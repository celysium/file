<?php

use Celysium\File\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api/file')->name('file.')->group(function () {

    Route::get('list', [FileController::class, 'list']);
    Route::post('list', [FileController::class, 'create']);
    Route::delete('list', [FileController::class, 'delete']);
});
