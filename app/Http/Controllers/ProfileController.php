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
        $week = collect();
        $past = collect();
        foreach ($user->followings as $following) {

            foreach ($following->videos()->with('user')->whereDate('created_at', today())->get() as $video) {
                $today->push($video);
            }

            foreach ($following->videos()->with('user')->whereDate('created_at', today()->subDay())->get() as $video) {
                $yesterday->push($video);
            }

            foreach ($following->videos()->with('user')->whereBetween('created_at', [today()->subDay()->subWeek(), today()->subDay()])->get() as $video) {
                $week->push($video);
            }

            foreach ($following->videos()->with('user')->whereBetween('created_at', [today()->subDecade(), today()->subDay()->subWeek()])->get() as $video) {
                $past->push($video);
            }
        }

        return view('home', [
            'today' => $today,
            'yesterday' => $yesterday,
            'week' => $week,
            'past' => $past,
        ]);
    }
}
