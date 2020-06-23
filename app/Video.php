<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property string slug
 * @property string title
 * @property string disk
 * @property string path
 * @property int duration
 * @property timestamp converted_for_streaming_at
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
        return Storage::disk('minio')->url('videos/' . $this->id . '/video.m3u8');
    }

    public function thumbnail(): string
    {
        return Storage::disk('minio')->url('videos/' . $this->id . '/thumbnail.png');
    }
}
