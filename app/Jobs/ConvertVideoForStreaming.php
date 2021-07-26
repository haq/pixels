<?php

namespace App\Jobs;

use App\Models\Video;
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

    public function __construct(private Video $video)
    {
    }

    public function handle()
    {
        $lowBitrate = (new X264)->setKiloBitrate(1500);
        $midBitrate = (new X264)->setKiloBitrate(3500);
        $highBitrate = (new X264)->setKiloBitrate(7000);

        FFMpeg::fromDisk($this->video->disk)
            ->open($this->video->path)
            ->exportForHLS()
            ->toDisk('minio')
            ->addFormat($lowBitrate, function ($media) {
                //$media->scale(960, 720);
            })
            ->addFormat($midBitrate, function ($media) {
                //$media->scale(1280, 720);
            })
            ->addFormat($highBitrate, function ($media) {
                //$media->scale(1920, 1080);
            })
            ->save('videos/' . $this->video->uuid . '/video.m3u8');

        $this->video->update([
            'converted_for_streaming_at' => now(),
        ]);
    }
}
