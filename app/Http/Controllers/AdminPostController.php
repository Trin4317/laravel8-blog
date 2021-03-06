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
        // $attributes = $this->validatePost();

        // return the path where the file was stored
        // $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');

        // create the post as the authenticated user
        // auth()->user()->posts()->create($attributes);

        $attributes = array_merge($this->validatePost(), [
            'user_id' => request()->user()->id,
            'thumbnail' => request()->file('thumbnail')->store('thumbnails')
        ]);

        Post::create($attributes);

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
        $attributes = $this->validatePost($post);

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

    // nullable type for $post parameter
    protected function validatePost(?Post $post = null)
    {
        // similar to $post = isset($post) ? $post : new Post();
        $post ??= new Post();

        return request()->validate([
            'title' => 'required',
            'status' => ['required', Rule::in(['DRAFT', 'PUBLISHED'])],
            'slug' => ['required', Rule::unique('posts', 'slug')->ignore($post->id)],
            'thumbnail' => $post->exists ? ['image'] : ['required', 'image'],
            'excerpt' => 'required',
            'body' => 'required',
            'category_id' => ['required', Rule::exists('categories', 'id')],
            // user_id validation is only required when changing author in Edit mode
            'user_id' => Rule::exists('users', 'id')
        ]);
    }
}
