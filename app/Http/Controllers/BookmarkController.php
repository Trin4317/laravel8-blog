<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class BookmarkController extends Controller
{
    // display bookmarked posts of current logging in user
    public function index()
    {
        return view('users.bookmark', [
            'bookmarks' => auth()->user()->bookmarks,
        ]);
    }

    // bookmark a specific post based on its id
    public function create(Post $post)
    {
        auth()->user()->bookmarks()->attach($post->id);

        return back()->with('success', 'Post Bookmarked!');
    }

    // remove a specific post from bookmark list
    public function destroy(Post $post)
    {
        auth()->user()->bookmarks()->detach($post->id);

        return back()->with('success', 'Post was removed from bookmark!');
    }
}
