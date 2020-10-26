<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Livewire\Videos\CreateVideo;
use App\Http\Livewire\Videos\ShowVideo;
use App\Models\Video;

Auth::routes();

Route::get('/', [ProfileController::class, 'index'])->name('home');

Route::prefix('user')->group(function () {
    Route::get('{user}', [UsersController::class, 'show'])->name('user.show');
});

Route::prefix('videos')->group(function () {
    Route::get('/', function () {
        $videos = Video::orderBy('created_at', 'desc')
            ->where('converted_for_streaming_at', '<>', null)
            ->get();
        return view('video.index')->with('videos', $videos);
    })->name('videos.index');

    Route::get('create', CreateVideo::class)
        ->middleware('auth')
        ->name('videos.create');

    Route::get('{slug}', ShowVideo::class)
        ->name('videos.show');
});
