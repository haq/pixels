<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\GenerateVideoThumbnail;
use App\Video;
use Exception;
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
        return view('video.index')->with('videos', Video::all());
    }

    public function create()
    {
        return view('video.create');
    }

    public function show($id)
    {
        try {
            $videoId = $this->hashids->decode($id)[0];
            $video = Video::findOrFail($videoId);
            return view('video.show')->with('video', $video);
        } catch (Exception  $exception) {
            abort(404);
        }
    }

    public function store(StoreVideoRequest $request)
    {
        $video = Video::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'disk' => 'videos_disk',
            'path' => $request->video->store(null, 'videos_disk'),
        ]);

        ConvertVideoForStreaming::withChain([
            new GenerateVideoThumbnail($video),
        ])->dispatch($video);

        return redirect('videos/' . $this->hashids->encode($video->id))->with(
            'message',
            'Your video will be available shortly after it is processed.'
        );
    }
}
