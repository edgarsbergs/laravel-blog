<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\TagController;
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
    /* Posts */
    Route::get('admin/posts', [PostController::class, 'adminList'])->name('admin/post/list');
    Route::get('admin/post/{id}', [PostController::class, 'editContent'])->name('admin/post');
    Route::get('admin/post/save', [PostController::class, 'update'])->name('admin/savePost');
    Route::get('admin/post/{id}/delete', [PostController::class, 'destroy'])->name('admin/deletePost');
    Route::get('admin/post-new', [PostController::class, 'newPost'])->name('new_post');
    Route::post('admin/post-new/save', [PostController::class, 'store'])->name('storePost');
    Route::post('admin/post/update', [PostController::class, 'updatePost'])->name('updatePost');

    /* Pages */
    Route::get('admin/pages', [PageController::class, 'adminList'])->name('admin/page/list');
    Route::get('admin/page/{id}', [PageController::class, 'editContent'])->name('admin/page');
    Route::get('admin/page-new', [PageController::class, 'newPost'])->name('new_page');

    Route::get('admin/comments', [AdminController::class, 'comments'])->name('admin/comments');
    Route::get('admin/menus', [AdminController::class, 'menus'])->name('admin/menus');
    Route::get('admin/users', [AdminController::class, 'users'])->name('admin/users');
    Route::get('admin/user/{id}', [AdminController::class, 'user'])->name('admin/user');
    Route::get('admin/settings', [AdminController::class, 'settings'])->name('admin/settings');
    Route::post('admin/settings/update', [SettingController::class, 'update'])->name('updateSettings');

    /* Frontend */
    Route::post('comment/add', [CommentController::class, 'store'])->name('addComment');
    Route::post('comment/delete/{id}', [CommentController::class, 'destroy']);
});

/* User */
Route::get('user/{id}', [UserController::class, 'profile'])->whereNumber('id')->name('profile');
Route::get('user/{id}/posts', [UserController::class, 'user_posts'])->whereNumber('id');

Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscribe');

Route::get('logout', [LoginController::class, 'logout']);

/* show posts by tag */
Route::get('/tag/{slug}', [TagController::class, 'show'])->where('slug', '[A-Za-z0-9-_]+')->name('showTag');

/* show post */
Route::get('/{slug}', [PostController::class, 'show'])->where('slug', '[A-Za-z0-9-_]+')->name('showPost');

