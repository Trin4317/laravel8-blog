<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;

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
    return view('posts', [
        'posts' => Post::all()
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
