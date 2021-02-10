<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class FollowUser extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Request $request, $id)
    {
        $user = auth()->user();
        $user_to_follow = User::findOrFail($id);

        if ($user->id === $user_to_follow) {
            return back()->with('error', 'Cannot follow/unfollow yourself.');
        }

        if ($user->isFollowing($user_to_follow)) {
            $user->unfollow($user_to_follow);
        } else {
            $user->follow($user_to_follow);
        }

        return back()->with('success', 'User followed/unfollowed.');
    }
}
