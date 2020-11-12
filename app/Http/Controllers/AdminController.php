<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Setting;

class AdminController extends Controller
{
    private $globalSettings;

    public function __construct()
    {
        $this->globalSettings = Setting::get();
    }

    /**
     * Admin dashboard
     *
     * @return view
     */
    public function index()
    {
        $postsCount = Post::where('active', 1)->count();
        $commentsCount = Comment::count();

        return view('admin/index', [
            'postsCount'    => $postsCount,
            'commentsCount' => $commentsCount,
        ]);
    }

    /**
     * Shows list of posts
     *
     * @return view
     */
    public function posts()
    {
        $posts = Post::paginate(5);

        return view('admin/posts', [
            'posts' => $posts,
        ]);
    }

    /**
     * Shows list of comments
     *
     * @return view
     */
    public function comments()
    {
        $comments = Comment::with('post')->paginate(5);

        return view('admin/comments', [
            'comments' => $comments,
        ]);
    }

    /**
     * Shows list of users
     *
     * @return view
     */
    public function users()
    {
        $users = User::all();

        return view('admin/users', [
            'users' => $users,
        ]);
    }

    /**
     * Shows user profile
     *
     * @return view
     */
    public function user($id)
    {
        $user = User::find($id);

        return view('admin/user', [
            'user' => $user,
        ]);
    }

    /**
     * Shows sites menus
     *
     * @return view
     */
    public function menus()
    {
        $menus = [];

        return view('admin/menus', [
            'menus' => $menus,
        ]);
    }

    /**
     * Shows site settings
     *
     * @return view
     */
    public function settings()
    {
        $settings = Setting::all();

        return view('admin/settings', [
            'settings' => $settings,
        ]);
    }

    /**
     * Shows edit post form
     *
     * @param int $id
     * @return view
     */
    public function editPost($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return redirect(route('admin/posts'))->withErrors(__('messages.post_doesnt_exist'));
        }

        return view('admin/posts-edit', [
            'post' => $post,
        ]);
    }

    /**
     * Shows new post form
     *
     * @param object $request
     * @return resource
     */
    public function newPost(Request $request)
    {
        if ($request->user()->can_post()) {
            return view('admin/posts-new');

        } else {
            return redirect(route('admin/posts'))->withErrors(__('messages.no_permission_writing_post'));
        }
    }
}
