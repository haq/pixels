<?php

namespace App\Http\Livewire\Videos;

use App\Models\Video;
use Livewire\Component;

class ShowVideo extends Component
{
    public Video $video;

    // editing
    public string $title = '';
    public bool $editMode = false;

    protected $rules = [
        'title' => 'required|string|max:191',
    ];

    public function mount(string $slug)
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

    public function enableEditMode()
    {
        $this->title = $this->video->title;
        $this->editMode = true;
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
