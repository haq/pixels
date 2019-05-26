<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\GenerateVideoThumbnail;
use App\Video;
use ErrorException;
use Hashids\Hashids;
use Mockery\Exception;

class VideosController extends Controller
{
    private $hashids;

    public function __construct()
    {
        $this->hashids = new Hashids();
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
        } catch (ErrorException  $exception) {
            abort(404);
        }
    }

    public function store(StoreVideoRequest $request)
    {
        $video = Video::create([
            'disk' => 'videos_disk',
            'original_name' => $request->video->getClientOriginalName(),
            'path' => $request->video->store('videos', 'videos_disk'),
            'title' => $request->title,
        ]);

        ConvertVideoForStreaming::withChain([
            new GenerateVideoThumbnail($video),
        ])->dispatch($video);

        return redirect('videos/' . $this->hashids->encode($video->id))->with(
            'message',
            'Your video will be available shortly after we process it'
        );
    }
}
