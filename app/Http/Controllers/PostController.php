<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::latest()->filter(
                request(['search', 'category', 'author'])
                )->paginate(3)->withQueryString()
        ]);
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post
        ]);
    }

    public function create()
    {
        if (auth()->guest()) {
            abort(403);
        };
        if (auth()->user()->username !== 'ollei'){
            abort(403);
        }
        return view('posts.create');
    }

    // 7 default CRUD actions
    // index, show, create, store, edit, update, destroy
}
