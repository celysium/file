<?php

use Celysium\File\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api/files')->name('files.')->group(function () {

    Route::get('list', [FileController::class, 'index'])->name('index'); // TODO index
    Route::post('/', [FileController::class, 'store'])->name('store');
    Route::delete('/', [FileController::class, 'delete'])->name('delete');
});
