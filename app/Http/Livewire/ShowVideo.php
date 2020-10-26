<?php

namespace App\Http\Livewire;

use App\Models\Video;
use Livewire\Component;

class ShowVideo extends Component
{
    public $video;

    public $title;
    public $editMode;

    protected $rules = [
        'title' => 'required|string|max:191',
    ];

    public function mount($slug)
    {
        $this->video = Video::where('slug', $slug)->firstOrFail();
    }

    // TODO: separate into multiple components
    public function render()
    {
        return view('livewire.show-video')
            ->extends('layouts.app');
    }

    public function submit()
    {
        $this->validate();

        $this->video->update([
            'title' => $this->title,
        ]);

        $this->editMode = false;
    }
}
