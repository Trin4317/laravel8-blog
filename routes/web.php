<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Http\Controllers\PostController;

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

Route::get('/', [PostController::class, 'index'])->name('home');

Route::get('post/{post}', [PostController::class, 'show']);

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
