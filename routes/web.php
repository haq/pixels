<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VideosController;
use App\Http\Livewire\Videos\CreateVideo;
use App\Http\Livewire\Videos\ShowVideo;

Auth::routes();

Route::get('/', [ProfileController::class, 'index'])->name('home');

Route::prefix('user')->group(function () {
    Route::get('{user}', [UsersController::class, 'show'])->name('user.show');
});

Route::resource('videos', VideosController::class)->except([
    'create', 'show', 'update', 'destroy', 'edit', 'store'
]);

Route::prefix('videos')->group(function () {
    Route::get('create', CreateVideo::class)->name('videos.create');
    Route::get('{slug}', ShowVideo::class)->name('videos.show');
});
