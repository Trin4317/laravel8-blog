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

Route::get('post/{post}', function($id) {
    // using findOrFail() method from Eloquent model
    // instead of passing $slug, pass $id instead

    return view('post', [
        'post' => Post::findOrFail($id)
    ]);

});
