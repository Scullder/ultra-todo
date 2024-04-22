<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return redirect()->route('lists.index');
});

Route::middleware('auth')->group(function () {
    Route::resource('lists', ListController::class);

    Route::prefix('lists/{list}')->group(function () {
        Route::resource('tasks', TaskController::class);
    });
});

Auth::routes();
