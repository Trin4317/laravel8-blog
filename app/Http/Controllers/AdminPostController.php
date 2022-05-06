<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class AdminPostController extends Controller
{
    public function index()
    {
        return view('admin.posts.index', [
            'posts' => Post::latest()->paginate(10)
        ]);
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store()
    {
        $post = new Post();

        $attributes = request()->validate([
            'title' => 'required',
            // since we are making new post, there is no self id to ignore, which means the rule still works as the same way
            'slug' => ['required', Rule::unique('posts', 'slug')->ignore($post->id)],
            'thumbnail' => $post->exists ? ['image'] : ['required', 'image'],
            'excerpt' => 'required',
            'body' => 'required',
            'category_id' => ['required', Rule::exists('categories', 'id')]
        ]);

        // $attributes['user_id'] = auth()->id();
        // Post::create($attributes);

        // return the path where the file was stored
        $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
        auth()->user()->posts()->create($attributes);

        return redirect('/');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', [
            'post' => $post
        ]);
    }

    public function update(Post $post)
    {
        $attributes = request()->validate([
            'title' => 'required',
            // ignore current post or else validation would fail
            'slug' => ['required', Rule::unique('posts', 'slug')->ignore($post->id)],
            // post can be updated without changing thumbnail so it's not required
            'thumbnail' => $post->exists ? ['image'] : ['required', 'image'],
            'excerpt' => 'required',
            'body' => 'required',
            'category_id' => ['required', Rule::exists('categories', 'id')]
        ]);

        // however if thumbnail is set then update the resource link to new thumbnail
        if (isset($attributes['thumbnail'])) {
            $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
        }

        $post->update($attributes);

        return back()->with('success', 'Post Updated!');
    }

    public function destroy(Post $post)
    {
        // first delete the thumbnail attached to the post
        if (Storage::exists($post->thumbnail)) {
            Storage::delete($post->thumbnail);
        }

        // then delete the post
        $post->delete();

        return back()->with('success', 'Post Deleted!');
    }
}
