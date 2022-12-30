<?php

use Celysium\File\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api/file')->name('file.')->group(function () {

    Route::get('list', [FileController::class, 'list'])->name('list');
    Route::post('', [FileController::class, 'store'])->name('store');
    Route::delete('', [FileController::class, 'delete'])->name('delete');
});
