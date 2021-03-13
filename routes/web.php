<?php

use App\Http\Controllers\Actions\FollowUser;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VideosController;
use App\Http\Livewire\ShowUser;
use App\Http\Livewire\Videos\CreateVideo;
use App\Http\Livewire\Videos\ShowVideo;

Auth::routes();

Route::get('/', [ProfileController::class, 'index'])
    ->name('home');

Route::prefix('user')->group(function () {
    Route::get('{name}', ShowUser::class)
        ->name('users.show');

    Route::post('/follow/{user}', FollowUser::class)
        ->name('users.follow');
});

Route::prefix('videos')->group(function () {
    Route::get('/', [VideosController::class, 'index'])
        ->name('videos.index');

    Route::get('create', CreateVideo::class)
        ->middleware('auth')
        ->name('videos.create');

    Route::get('{uuid}', ShowVideo::class)
        ->name('videos.show');
});
