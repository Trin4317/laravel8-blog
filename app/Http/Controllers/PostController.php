<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::where('status', 'PUBLISHED')
                ->latest()
                ->filter(
                    request(['search', 'category', 'author'])
                )->paginate(3)->withQueryString()
        ]);
    }

    public function show(Post $post)
    {
        if ($post->status !== 'PUBLISHED') {
            abort(404);
        }

        if ($this->shouldCount($post)) {
            $post->increment('total_views');
        }

        return view('posts.show', [
            'post' => $post
        ]);
    }

    // 7 default CRUD actions
    // index, show, create, store, edit, update, destroy

    // add 1 minute cooldown for each post per session (either auth or guess)
    // return true if user has any attempt left
    protected function shouldCount(Post $post)
    {
        return RateLimiter::attempt(
            'view-post:'.session()->getId().$post->id,
            $perMinute = 1,
            function() {
                return true;
            }
        );
    }
}
