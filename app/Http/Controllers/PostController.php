<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Traits\Content;

class PostController extends Controller
{
    use Content;

    protected $post_type;

    public function __construct()
    {
        $this->post_type = 'post';
    }

    public function index()
    {
        $posts = Post::where('active', 1)
                        ->orderBy('created_at','desc')
                        ->paginate(5);

        return view('home', [
            'posts' => $posts,
        ]);
    }

}
