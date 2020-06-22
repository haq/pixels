<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function show($name)
    {
        $user = User::where('name', $name)->firstOrFail();
        return $user;
    }
}
