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

        // updating the duration of the video
        $vid = Video::find($this->video->id);
        $vid->duration = $media->getDurationInMiliseconds();
        $vid->save();

        $media->getFrameFromSeconds($durationInSeconds / 2)
            ->export()
            ->toDisk('minio')
            ->withVisibility('public')
            ->save('videos/' . $this->video->id . '/thumbnail.png');
    }
}
