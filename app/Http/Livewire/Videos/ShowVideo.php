<?php

namespace App\Http\Livewire\Videos;

use App\Models\Video;
use Livewire\Component;

class ShowVideo extends Component
{
    public $video;

    public function mount($slug)
    {
        $this->video = Video::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.videos.show-video')
            ->extends('layouts.app');
    }

}
