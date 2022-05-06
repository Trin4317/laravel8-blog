<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostCommentsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\NewsletterController;

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

Route::post('post/{post}/comment', [PostCommentsController::class, 'store']);

// inspect the request with middleware logic before hitting the controller
Route::get('register', [RegisterController::class, 'create'])->middleware('guest');

Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('login', [SessionController::class, 'create'])->middleware('guest');

Route::post('sessions', [SessionController::class, 'store'])->middleware('guest');

Route::post('logout', [SessionController::class, 'destroy'])->middleware('auth');

Route::post('newsletter', NewsletterController::class);

Route::get('admin/posts', [AdminPostController::class, 'index'])->middleware('admin');

Route::get('admin/posts/create', [AdminPostController::class, 'create'])->middleware('admin');

Route::post('admin/posts', [AdminPostController::class, 'store'])->middleware('admin');

Route::get('admin/posts/{post:id}/edit', [AdminPostController::class, 'edit'])->middleware('admin');

Route::patch('admin/posts/{post:id}', [AdminPostController::class, 'update'])->middleware('admin');

Route::delete('admin/posts/{post:id}', [AdminPostController::class, 'destroy'])->middleware('admin');
