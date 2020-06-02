<?php

namespace App\Jobs;

use App\Video;
use Carbon\Carbon;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ConvertVideoForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    private $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function handle()
    {
        FFMpeg::fromDisk($this->video->disk)
            ->open($this->video->path)
            ->exportForHLS()
            /*       ->dontSortFormats()*/
            ->toDisk('minio')
            ->addFormat((new X264())->setKiloBitrate(1500))
            ->addFormat((new X264())->setKiloBitrate(2500))
            ->addFormat((new X264())->setKiloBitrate(5000))
            ->save('videos' . $this->video->id . '/video.m3u8');

        $this->video->update([
            'converted_for_streaming_at' => Carbon::now(),
        ]);
    }
}
