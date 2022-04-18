<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;

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
    // in this case, each post needs to fetch $post->category and $post->author for posts view
    // so if there are 50 posts it will execute SQL query 50x2 times!

    // solving n+1 problem
    // force Laravel to eager load any relationship that will be referenced later
    // by doing that, each post will never need to fetch $post->category and $post->author
    // as the information about other tables is already preloaded
    return view('posts', [
        // parameter inside with is the property defined in Post model
        // using latest() method to sort by order of updated_at
        'posts' => Post::latest()->get(),
        'categories' => Category::all()
    ]);
})->name('home');

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

Route::get('categories/{category}', function (Category $category) {
    // using route-model binding
    // binding a route key {category} to underlying Eloquent Category model
    // using posts property to fetch all data from a single category

    // solving n+1 when the data isnt fetched from the Class but Collection
    // using load method to eager load the relationship between Post model and others
    return view('posts', [
        'posts' => $category->posts,
        'categories' => Category::all(),
        'currentCategory' => $category
    ]);
})->name('category');

Route::get('authors/{author}', function (User $author) {
    // using route-model binding
    // binding a route key {author} to underlying Eloquent User model
    // using posts property to fetch all data from a single author
    return view('posts', [
        'posts' => $author->posts,
        'categories' => Category::all()
    ]);
});
