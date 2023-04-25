<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $today = [];
        $yesterday = [];
        $week = [];
        $past = [];

        foreach ($user->followings as $following) {
            $today[] = self::getVideos($following, today(), today());
            array_push($yesterday, ...self::getVideos($following, today()->subDay(), today()->subDay()));
            array_push($week, ...self::getVideos($following, today()->subDay()->subWeek(), today()->subDay()));
            array_push($past, ...self::getVideos($following, today()->subDecade(), today()->subDay()->subWeek()));
        }

        return view('home', [
            'today' => $today,
            'yesterday' => $yesterday,
            'week' => $week,
            'past' => $past,
        ]);
    }

    private static function getVideos($users, Carbon $start, Carbon $end): Collection
    {
        return $users->videos()
            ->with('user')
            ->whereBetween('created_at', [$start, $end])
            ->get();
    }
}
