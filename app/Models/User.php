<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Overtrue\LaravelFollow\Traits\Follower;
use Overtrue\LaravelFollow\Traits\Followable;

/**
 * @property string name
 * @property string email
 * @property string stream_key
 *
 * @property string image
 */
class User extends Authenticatable
{
    use Notifiable;
    use Follower;
    use Followable;

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

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (User $user) {
            $user->stream_key = bin2hex(openssl_random_pseudo_bytes(30));
        });
    }

    protected function hash(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => md5($attributes['created_at']),
        );
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => 'https://avatar.vercel.sh/' . $this->hash . '.svg?text=' . strtoupper(substr($attributes['name'], 0, 2)),
        );
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }
}
