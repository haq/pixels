<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\GenerateVideoThumbnail;
use App\Video;
use Hashids\Hashids;

class VideosController extends Controller
{
    private $hashids;

    public function __construct()
    {
        $this->hashids = new Hashids();
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

    public function create()
    {
        return view('video.create');
    }

    public function show($slug)
    {
        $video = Video::where('slug', $slug)->firstOrFail();
        return view('video.show')->with('video', $video);
    }

    public function store(StoreVideoRequest $request)
    {
        $video = Video::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'disk' => 'minio',
            'path' => $request->video->store('original', 'minio')
        ]);

        $video->slug = $this->hashids->encode($video->id);
        $video->save();

        ConvertVideoForStreaming::withChain([
            new GenerateVideoThumbnail($video),
        ])->dispatch($video);

        return redirect("videos/$video->slug")->with('message', 'Your video will be available shortly after it is processed.');
    }
}
