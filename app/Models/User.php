<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Overtrue\LaravelFollow\Followable;

/**
 * @property string name
 * @property string email
 * @property string stream_key
 *
 * @property string image
 */
class User extends Authenticatable
{
    use Notifiable, Followable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'stream_key',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'stream_key',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function getImageAttribute()
    {
        return 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email)));
    }

}
