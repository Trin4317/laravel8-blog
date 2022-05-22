<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class RssFeedController extends Controller
{
    public function __invoke()
    {
        $posts = Post::latest()
                    ->where('status', 'PUBLISHED')
                    ->limit(5)
                    ->get();

        $content = view('rss.feed', compact('posts'));

        return response($content, 200)->header('Content-Type', 'application/xml');
    }
}
