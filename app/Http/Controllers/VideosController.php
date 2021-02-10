<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Support\Carbon;

class VideosController extends Controller
{
    public function index()
    {
        $months = Video::with('user')
            ->orderByDesc('created_at')
            ->whereNotNull('converted_for_streaming_at')
            ->get()
            ->groupBy(function ($data) {
                return Carbon::parse($data->created_at)->format('Y-m');
            });

        return view('video.index')->with('months', $months);
    }

    public function show(string $slug)
    {
        $video = Video::with('user')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('video.show')->with('video', $video);
    }
}
