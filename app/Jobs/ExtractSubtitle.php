<?php

namespace App\Jobs;

use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExtractSubtitle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Video $video)
    {
    }

    public function handle()
    {
        // TODO: copy video to tmp location

        // TODO: extract subtitle if exists
        exec('ffmpeg -hide_banner -i rick.and.morty.s05e05.1080p.webrip.x264-cakes.mkv -map 0:s:1 subtitle.srt');

        // TODO: convert srt to vtt

        // TODO: copy over .vtt subtitle file

        // TODO: delete tmp file
    }
}
