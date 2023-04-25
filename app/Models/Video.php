<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * @property string uuid
 * @property int user_id
 * @property string title
 * @property string disk
 * @property string path
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
        'uuid',
        'duration',
        'converted_for_streaming_at',
    ];

    protected $casts = [
        'converted_for_streaming_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function processed(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $attributes['converted_for_streaming_at'] !== null,
        );
    }

    protected function video(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => Storage::url('videos/' . $attributes['$this->uuid'] . '/video.m3u8'),
        );
    }

    protected function thumbnail(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => Storage::url('videos/' . $attributes['$this->uuid'] . '/thumbnail.png'),
        );
    }
}
