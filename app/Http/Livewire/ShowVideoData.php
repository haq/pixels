<?php

namespace App\Http\Livewire;

use App\Models\Video;
use Livewire\Component;

class ShowVideoData extends Component
{
    public $video;

    public $title;
    public $editMode;

    protected $rules = [
        'title' => 'required|string|max:191',
    ];

    public function mount(Video $video)
    {
        $this->video = $video;
    }

    public function render()
    {
        return view('livewire.show-video-data');
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
