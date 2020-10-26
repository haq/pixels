<?php

use App\Models\User;
use Illuminate\Http\Request;

Route::get("streamauth", function (Request $request) {
    Log::info($request->input('name'));

    $user = User::where('stream_key', $request->input('name'))
        ->firstOrFail();

    return response('ok', 202);

    return redirect("rtmp://127.0.0.1/live/$user->id");
});
