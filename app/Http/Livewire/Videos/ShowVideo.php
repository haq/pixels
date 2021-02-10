<?php

namespace App\Http\Livewire\Videos;

use App\Models\Video;
use Livewire\Component;

// TODO: convert to blade component
class ShowVideo extends Component
{
    public $video;

    public function mount($slug)
    {
        $this->video = Video::with('user')
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.videos.show-video')
            ->extends('layouts.app');
    }

}
