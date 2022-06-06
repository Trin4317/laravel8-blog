<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostCommentsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\RssFeedController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\BookmarkController;

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

Route::get('login', [SessionController::class, 'create'])->middleware('guest')->name('login');

Route::post('sessions', [SessionController::class, 'store'])->middleware('guest');

Route::post('logout', [SessionController::class, 'destroy'])->middleware('auth');

Route::get('profile/follow', [FollowController::class, 'index'])->middleware('auth');

// customize missing model behavior
Route::post('profile/follow/{user:id}', [FollowController::class, 'create'])
        ->middleware('auth')
        ->missing(function (Request $request) {
            return back()->with('error', 'User does not exist.');
        });

Route::post('profile/unfollow/{user:id}', [FollowController::class, 'destroy'])
        ->middleware('auth')
        ->missing(function (Request $request) {
            return back()->with('error', 'User does not exist.');
        });

Route::get('profile/bookmark', [BookmarkController::class, 'index'])->middleware('auth');

// customize missing model behavior
Route::post('profile/bookmark/{post:id}', [BookmarkController::class, 'create'])
        ->middleware('auth')
        ->missing(function (Request $request) {
            return back()->with('error', 'Post does not exist.');
        });

Route::post('profile/unbookmark/{post:id}', [BookmarkController::class, 'destroy'])
        ->middleware('auth')
        ->missing(function (Request $request) {
            return back()->with('error', 'Post does not exist.');
        });

Route::post('newsletter', NewsletterController::class);

Route::get('feed', RssFeedController::class);

Route::middleware('can:admin')->group(function () {
    // another way is using route resource to automatically list all routes with 7 CRUD actions
    // Route::resource('admin/posts', AdminPostController::class)->except('show');
    Route::get('admin/posts', [AdminPostController::class, 'index']);
    Route::get('admin/posts/create', [AdminPostController::class, 'create']);
    Route::post('admin/posts', [AdminPostController::class, 'store']);
    Route::get('admin/posts/{post:id}/edit', [AdminPostController::class, 'edit']);
    Route::patch('admin/posts/{post:id}', [AdminPostController::class, 'update']);
    Route::delete('admin/posts/{post:id}', [AdminPostController::class, 'destroy']);
});
