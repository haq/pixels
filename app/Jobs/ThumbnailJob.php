<?php

namespace App\Jobs;

use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ThumbnailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public readonly Video $video)
    {
    }

    public function handle(): void
    {
        $media = FFMpeg::fromDisk($this->video->disk)
            ->open($this->video->path);

        $duration = $this->video->duration / 1000;

        $media->getFrameFromSeconds($duration / 2)
            ->export()
            ->toDisk('local')
            ->withVisibility('public')
            ->save('videos/' . $this->video->uuid . '/thumbnail.png');
    }
}
