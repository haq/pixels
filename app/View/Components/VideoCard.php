<?php

namespace App\View\Components;

use Illuminate\View\Component;

class VideoCard extends Component
{
    public $video;
    public $showUserImage;

    public function __construct($video, $showUserImage)
    {
        $this->video = $video;
        $this->showUserImage = $showUserImage;
    }

    public function render()
    {
        return view('components.video-card');
    }
}
