<?php

namespace App\Jobs;

use App\Models\Video;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSVideoFilters;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ConvertVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 600;
    public bool $failOnTimeout = true;

    public function __construct(private readonly Video $video)
    {
    }

    public function handle(): void
    {
        $lowFormat = (new X264)->setKiloBitrate(2500);
        $midFormat = (new X264)->setKiloBitrate(5000);
        $highFormat = (new X264)->setKiloBitrate(8000);

        FFMpeg::fromDisk($this->video->disk)
            ->open($this->video->path)
            ->exportForHLS()
            ->toDisk('local')
            /*  ->addFormat($lowFormat, function (HLSVideoFilters $filters) {
                  $filters->resize(640, 480);
              })
              ->addFormat($midFormat, function (HLSVideoFilters $filters) {
                  $filters->resize(1280, 720);
              })*/
            ->addFormat($highFormat, function (HLSVideoFilters $filters) {
                //$filters->resize(1920, 1080);
            })
            ->onProgress(function ($percentage) {
                //VideoStatusUpdate::dispatch($this->video->uuid, $percentage);
                echo "{$percentage}% transcoded\n";
            })
            ->save('videos/' . $this->video->uuid . '/video.m3u8');

        $this->video->update([
            'converted_for_streaming_at' => now(),
        ]);
    }
}
