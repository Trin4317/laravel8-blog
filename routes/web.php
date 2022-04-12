<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
    DB::listen(function ($query) {
        logger($query->sql, $query->bindings);
    });
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

Route::get('category/{category}', function (Category $category) {
    // using route-model binding
    // binding a route key {category} to underlying Eloquent Category model
    // using posts property to fetch all data from a single category
    return view('posts', [
        'posts' => $category->posts
    ]);
});
