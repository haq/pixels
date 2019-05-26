<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

/*
 * Videos
 */
/*Route::get('/videos', 'VideosController@index')->name('video.index');
Route::get('/videos', 'VideosController@create')->name('video.create');
Route::get('/videos/{id}', 'VideosController@show')->name('video.show');
Route::post('/videos/upload', 'VideosController@store')->name('video.upload');*/

Route::resource('videos', 'VideosController')->except([
    'update', 'destroy', 'edit'
]);