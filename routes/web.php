<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
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

Route::get('/', [PostController::class, 'index']);

Route::middleware(['auth'])->group(function () {
    Route::get('new-post', [PostController::class, 'create']);
    Route::post('new-post', [PostController::class, 'store']);
    Route::get('edit/{slug}', [PostController::class, 'edit']);
    Route::post('update', [PostController::class, 'update']);
    Route::get('delete/{id}', [PostController::class, 'destroy']);

    Route::get('my-all-posts', [UserController::class, 'user_posts_all']);
    Route::get('my-drafts', [UserController::class, 'user_posts_draft']);

    Route::post('comment/add', [CommentController::class, 'store']);
    Route::post('comment/delete/{id}', [CommentController::class, 'destroy']);
});


Route::get('user/{id}', 'App\Http\Controllers\UserController@profile')->whereNumber('id')->name('profile');
Route::get('user/{id}/posts', 'App\Http\Controllers\UserController@user_posts')->whereNumber('id');
// show post
Route::get('/{slug}', 'App\Http\Controllers\PostController@show')->where('slug', '[A-Za-z0-9-_]+');

Route::post('subscribe', 'App\Http\Controllers\SubscriberController@store');

