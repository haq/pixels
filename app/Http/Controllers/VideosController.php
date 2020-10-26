<?php

namespace App\Http\Controllers;


use App\Models\Video;

class VideosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except([
            'index', 'show'
        ]);
    }

    public function index()
    {
        $videos = Video::orderBy('created_at', 'desc')
            ->where('converted_for_streaming_at', '<>', null)
            ->get();
        return view('video.index')->with('videos', $videos);
    }
}
