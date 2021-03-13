<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function creating(User $user)
    {
        $user->stream_key = bin2hex(openssl_random_pseudo_bytes(30));
    }
}
