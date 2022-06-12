<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
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
        try {
            auth()->user()->followings()->attach($user->id);
        }
        catch (QueryException $e) {
            // if the relationship already exists
            return back()->with('error', 'Already followed this user!');
        }

        return back()->with('success', 'User Followed!');
    }

    // unfollow a specific user based on his id
    public function destroy(User $user)
    {
        // no exception is thrown when we detach a non-exist relationship so no need to catch
        auth()->user()->followings()->detach($user->id);

        return back()->with('success', 'User Unfollowed!');
    }
}
