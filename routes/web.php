<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // using all() method from Eloquent model to fetch all data

    // introducing n+1 problem
    // since Laravel lazy loads relationship between tables (Eloquent models)
    // it will execute additional SQL query for each item in the loop if the item needs to fetch data from other table
    // in this case, each post needs to fetch $post->category for posts view
    // so if there are 50 posts it will execute SQL query 50 times!

    // solving n+1 problem
    // force Laravel to eager load any relationship that will be referenced later
    // by doing that, each post will never need to fetch $post->category
    // as the information about other tables is already preloaded
    return view('posts', [
        // parameter inside with is the property defined in Post model
        // using latest() method to sort by order of updated_at
        'posts' => Post::latest()->with('category')->get()
    ]);
});

Route::get('post/{post}', function(Post $post) {
    // using route-model binding
    // binding a route key {post} to underlying Eloquent Post model
    // wildcard name MUST match variable name
    // define a different route key by using getRouteKeyName() method in Post model
    // it equals to Post::where('slug', $post)->firstOrFail();

    return view('post', [
        'post' => $post
    ]);

});

Route::get('category/{category}', function (Category $category) {
    // using route-model binding
    // binding a route key {category} to underlying Eloquent Category model
    // using posts property to fetch all data from a single category
    return view('posts', [
        'posts' => $category->posts
    ]);
});
