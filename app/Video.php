<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property Carbon converted_for_streaming_at
 */
class Video extends Model
{
    protected $dates = [
        'converted_for_streaming_at'
    ];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function processed(): bool
    {
        return $this->converted_for_streaming_at != null;
    }

    public function video(): string
    {
        return Storage::disk('streamable_videos')->url($this->id . '/video.m3u8');
    }

    public function thumbnail(): string
    {
        return Storage::disk('streamable_videos')->url($this->id . '/thumbnail.png');
    }

}
