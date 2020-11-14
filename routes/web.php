<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SubscriberController;
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

Auth::routes();

Route::get('/', [PostController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    /* Admin panel */
    Route::get('admin', [AdminController::class, 'index'])->name('admin');
    Route::get('admin/posts', [AdminController::class, 'posts'])->name('admin/posts');
    Route::get('admin/post/{id}', [AdminController::class, 'editPost'])->name('admin/post');
    Route::get('admin/post/save', [PostController::class, 'update'])->name('admin/savePost');
    Route::get('admin/post/{id}/delete', [PostController::class, 'destroy'])->name('admin/deletePost');
    Route::get('admin/post-new', [AdminController::class, 'newPost'])->name('newPost');
    Route::post('admin/post-new/save', [PostController::class, 'store'])->name('storePost');
    Route::post('admin/post/update', [PostController::class, 'updatePost'])->name('updatePost');

    Route::get('admin/comments', [AdminController::class, 'comments'])->name('admin/comments');
    Route::get('admin/menus', [AdminController::class, 'menus'])->name('admin/menus');
    Route::get('admin/users', [AdminController::class, 'users'])->name('admin/users');
    Route::get('admin/user/{id}', [AdminController::class, 'user'])->name('admin/user');
    Route::get('admin/settings', [AdminController::class, 'settings'])->name('admin/settings');
    Route::post('admin/settings/update', [SettingController::class, 'update'])->name('updateSettings');

    /* Frontend */
    Route::post('comment/add', [CommentController::class, 'store']);
    Route::post('comment/delete/{id}', [CommentController::class, 'destroy']);
});

Route::get('user/{id}', [UserController::class, 'profile'])->whereNumber('id')->name('profile');
Route::get('user/{id}/posts', [UserController::class, 'user_posts'])->whereNumber('id');
// show post
Route::get('/{slug}', [PostController::class, 'show'])->where('slug', '[A-Za-z0-9-_]+')->name('showPost');

Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscribe');

