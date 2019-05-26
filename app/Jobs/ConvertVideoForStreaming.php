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

class ConvertVideoForStreaming implements ShouldQueue
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
        $lowBitrateFormat = (new X264($audioCodec = 'libmp3lame'))->setKiloBitrate(1500);
        $midBitrateFormat = (new X264($audioCodec = 'libmp3lame'))->setKiloBitrate(2500);
        $highBitrateFormat = (new X264($audioCodec = 'libmp3lame'))->setKiloBitrate(5000);

        FFMpeg::fromDisk($this->video->disk)
            ->open($this->video->path)
            ->exportForHLS()
            ->dontSortFormats()
            ->toDisk('streamable_videos')
            ->addFormat($lowBitrateFormat)
            ->addFormat($midBitrateFormat)
            ->addFormat($highBitrateFormat)
            ->save($this->video->id . '/video.m3u8');

        $this->video->update([
            'converted_for_streaming_at' => Carbon::now(),
        ]);
    }
}
