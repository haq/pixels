<?php

namespace App\Jobs;

use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class GenerateVideoThumbnail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public Video $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function handle()
    {
        $media = FFMpeg::fromDisk($this->video->disk)
            ->open($this->video->path);

        $durationInSeconds = $media->getDurationInSeconds();

        // updating the duration of the video
        $this->video->update([
            'duration' => $media->getDurationInMiliseconds(),
        ]);

        $media->getFrameFromSeconds($durationInSeconds / 2)
            ->export()
            ->toDisk('minio')
            ->withVisibility('public')
            ->save('videos/' . $this->video->slug . '/thumbnail.png');
    }
}
