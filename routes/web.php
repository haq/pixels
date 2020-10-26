<?php

use App\Http\Controllers\ProfileController;
use App\Http\Livewire\ShowUser;
use App\Http\Livewire\Videos\CreateVideo;
use App\Http\Livewire\Videos\ShowVideo;
use App\Models\Video;

Auth::routes();

Route::get('/', [ProfileController::class, 'index'])->name('home');

Route::prefix('user')->group(function () {
    Route::get('{name}', ShowUser::class)
        ->name('users.show');
});

Route::prefix('videos')->group(function () {
    Route::get('/', function () {
        $videos = Video::with('user')
            ->orderBy('created_at', 'desc')
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
