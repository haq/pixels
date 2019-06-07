<?php

namespace App\Http\Controllers;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except([
            'show'
        ]);
    }

    public function index()
    {
        return view('profile');
    }

    public function show(string $user)
    {
        /* $user = User::getUserByName($user);
         if (!$user) {
             return abort(404);
         }
         return view('profile')->with([
             'user' => $user,
             'tweets' => $this->getTweets($user, false),
             'home' => false
         ]);*/
    }
}
