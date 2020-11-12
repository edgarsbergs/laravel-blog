<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Setting;

class AdminController extends Controller
{
    public function index()
    {
        $postsCount = Post::where('active', 1)->count();
        $commentsCount = Comment::count();

        return view('admin/index', [
            'postsCount'    => $postsCount,
            'commentsCount' => $commentsCount,
        ]);
    }

    // list of posts
    public function posts()
    {
        $posts = Post::all();

        return view('admin/posts', [
            'posts' => $posts,
        ]);
    }

    // list of comments
    public function comments()
    {
        $comments = Comment::with('post')->get();

        return view('admin/comments', [
            'comments' => $comments,
        ]);
    }

    // list of users
    public function users()
    {
        $users = User::all();

        return view('admin/users', [
            'users' => $users,
        ]);
    }

    // user profile
    public function user($id)
    {
        $user = User::find($id);

        return view('admin/user', [
            'user' => $user,
        ]);
    }

    // sites menus
    public function menus()
    {
        $menus = [];

        return view('admin/menus', [
            'menus' => $menus,
        ]);
    }

    // site settings
    public function settings()
    {
        $settings = Setting::all();

        return view('admin/settings', [
            'settings' => $settings,
        ]);
    }

    // shows edit post form
    public function editPost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return redirect(route('admin/posts'))->withErrors('Post doesnt exist');
        }

        return view('admin/posts-edit', [
            'post' => $post,
        ]);
    }
}
