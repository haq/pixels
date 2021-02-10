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
 *
 * @property bool processed
 * @property string video
 * @property string thumbnail
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

    public function getProcessedAttribute(): bool
    {
        return $this->converted_for_streaming_at !== null;
    }

    public function getVideoAttribute(): string
    {
        return Storage::cloud()->url("videos/$this->slug/video.m3u8");
    }

    public function getThumbnailAttribute(): string
    {
        return Storage::cloud()->url("videos/$this->slug/thumbnail.png");
    }
}
