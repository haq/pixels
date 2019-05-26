<?php

namespace App\Jobs;

use App\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateVideoThumbnail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function handle()
    {
        $media = FFMpeg::fromDisk($this->video->disk)
            ->open($this->video->path);

        $media->getFrameFromSeconds($media->getDurationInSeconds() / 2)
            ->export()
            ->toDisk('streamable_videos')
            ->save($this->video->id . '/frame.png');
    }
}
