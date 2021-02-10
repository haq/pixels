<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int user_id
 * @property string title
 * @property string disk
 * @property string path
 * @property string slug
 * @property int duration
 * @property Carbon converted_for_streaming_at
 */
class Video extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'disk',
        'path',
        'slug',
        'duration',
        'converted_for_streaming_at',
    ];

    protected $dates = [
        'converted_for_streaming_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function processed(): bool
    {
        return $this->converted_for_streaming_at !== null;
    }

    // TODO: change to slug
    public function getVideoAttribute(): string
    {
        return Storage::cloud()->url("videos/$this->id/video.m3u8");
    }

    public function getThumbnailAttribute(): string
    {
        return Storage::cloud()->url("videos/$this->id/thumbnail.png");
    }
}
