<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property timestamp converted_for_streaming_at
 * @property string disk
 * @property string path
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
        return Storage::disk('minio')->url($this->id . '/video.m3u8');
    }

    public function thumbnail(): string
    {
        return Storage::disk('minio')->url($this->id . '/thumbnail.png');
    }

}
