<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostCommentsController extends Controller
{
    public function store(Post $post)
    {
        // validation
        request()->validate([
            'body' => 'required'
        ]);

        // add a comment to the given post
        $post->comments()->create([
            'user_id' => auth()->user()->id,
            'body' => request('body')
        ]);

        // redirect back to previous page
        return back();
    }
}
