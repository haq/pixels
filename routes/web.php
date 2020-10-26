<?php

use App\Http\Livewire\ShowVideo;

Auth::routes();

Route::get('/', 'ProfileController@index')->name('home');

Route::prefix('user')->group(function () {
    Route::get('{user}', 'UsersController@show')->name('user.show');
});

Route::resource('videos', 'VideosController')->except([
    'show', 'update', 'destroy', 'edit'
]);

/*Route::get('/post', ShowVideo::class);*/
