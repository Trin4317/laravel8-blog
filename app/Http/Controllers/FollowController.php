<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FollowController extends Controller
{
    // display list of followers and followings of current logging in user
    public function index()
    {
        return view('users.follow', [
            'followers' => auth()->user()->followers,
            'followings' => auth()->user()->followings
        ]);
    }

    // follow a specific user based on his id
    public function create(User $user)
    {
        auth()->user()->followings()->attach($user->id);

        return back()->with('success', 'User Followed!');
    }

    // unfollow a specific user based on his id
    public function destroy(User $user)
    {
        auth()->user()->followings()->detach($user->id);

        return back()->with('success', 'User Unfollowed!');
    }
}
