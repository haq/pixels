<?php

namespace App\Jobs;

use App\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        FFMpeg::fromDisk($this->video->disk)
            ->open($this->video->path)
            ->getFrameFromSeconds(10)
            ->export()
            ->toDisk('streamable_videos')
            ->save($this->video->id . '/thumbnail.png');
    }
}
