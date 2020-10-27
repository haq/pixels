<?php

use App\Models\User;
use Illuminate\Http\Request;

Route::get('publish', function (Request $request) {
    Log::info('STREAM START');

    $user = User::where('stream_key', $request->input('name'))
        ->firstOrFail();

    // TODO: set the user stream to online

    return response($user->name, 302);
});

Route::get('publish_done', function (Request $request) {
    Log::info('STREAM END');

    // TODO: set the user stream to offline

    return response('OK');
});
