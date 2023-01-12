<?php

use Celysium\File\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('api')->name('api.')->group(function () {

    Route::prefix('files')->name('files.')->group(function () {
        Route::get('/', [FileController::class, 'index'])->name('index');
        Route::post('/', [FileController::class, 'store'])->name('store');
        Route::delete('/', [FileController::class, 'destroy'])->name('destroy');
    });
});
