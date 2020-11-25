<?php

namespace App\Http\Controllers;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        $today = collect();
        $yesterday = collect();
        foreach ($user->followings as $following) {
            $today->push(
                $following->videos()->with('user')->whereDate('created_at', today())->get()
            );
            $yesterday->push(
                $following->videos()->with('user')->whereDate('created_at', today()->subDay())->get()
            );
        }

        return count($yesterday);

        return view('home', [
            'today' => $today,
            'yesterday' => $yesterday
        ]);
    }
}
