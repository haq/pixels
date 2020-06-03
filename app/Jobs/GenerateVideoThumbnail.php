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
        $media = FFMpeg::fromDisk($this->video->disk)
            ->open($this->video->path);

        $durationInSeconds = $media->getDurationInSeconds();

        $media->getFrameFromSeconds($durationInSeconds / 2)
            ->export()
            ->toDisk('minio')
            ->withVisibility('public')
            ->save('videos/' . $this->video->id . '/thumbnail.png');
    }
}
