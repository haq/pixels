<?php

namespace App\Jobs;

use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class VideoDurationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly Video $video)
    {
    }

    public function handle(): void
    {
        $media = FFMpeg::fromDisk($this->video->disk)
            ->open($this->video->path);

        $this->video->update([
            'duration' => $media->getDurationInMiliseconds(),
        ]);
    }
}
