<?php

namespace App\Http\Livewire\Videos;

use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\GenerateVideoThumbnail;
use App\Models\Video;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateVideo extends Component
{
    use WithFileUploads;

    public string $title = '';
    public $video;

    protected array $rules = [
        'title' => 'required|string|max:191',
        'video' => 'required|file|mimetypes:video/mp4,video/x-matroska',
    ];

    public function render()
    {
        return view('livewire.videos.create-video')
            ->extends('layouts.app');
    }

    public function save()
    {
        $this->validate();

        $user = auth()->user();

        /** @var Video $video */
        $video = Video::create([
            'uuid' => Str::uuid(),
            'user_id' => $user->id,
            'title' => $this->title,
            'disk' => 'minio',
            'path' => $this->video->store('original', 'minio'),
        ]);

        Bus::chain([
            new GenerateVideoThumbnail($video),
            new ConvertVideoForStreaming($video),
        ])->dispatch();

        return redirect("user/$user->name");
    }
}
