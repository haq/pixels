<?php

namespace App\Http\Livewire\Videos;

use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\GenerateVideoThumbnail;
use App\Models\Video;
use Hashids\Hashids;
use Illuminate\Support\Facades\Bus;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateVideo extends Component
{
    use WithFileUploads;

    public string $title = '';
    public $video;

    protected $rules = [
        'title' => 'required|string|max:191',
        'video' => 'required|file|mimetypes:video/mp4',
    ];

    public function render()
    {
        return view('livewire.videos.create-video')
            ->extends('layouts.app');
    }

    public function save()
    {
        $this->validate();

        // TODO: replace with single query
        $videoModel = Video::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'disk' => 'minio',
            'path' => $this->video->store('original', 'minio'),
        ]);

        $videoModel->slug = (new Hashids())->encode($videoModel->id);
        $videoModel->save();

        Bus::chain([
            new GenerateVideoThumbnail($videoModel),
            new ConvertVideoForStreaming($videoModel),
        ])->dispatch();

        return redirect()
            ->to("videos/$videoModel->slug");
    }
}
