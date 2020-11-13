<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class UserController extends Controller {
    /**
     * Display active posts of a particular user
     *
     * @param int $id
     * @return view
     */
    public function user_posts($id)
    {
        $posts = Post::where('user_id',$id)->where('active', 1)->orderBy('created_at','desc')->paginate(5);
        $title = User::find($id)->name;

        return view('home', [
            'posts' => $posts,
            'title' => $title,
        ]);
    }

    /**
     * Displays user's profile
     *
     * @param object $request
     * @param int $id
     * @return view
     */
    public function profile(Request $request, $id)
    {
        $data['user'] = User::find($id);
        if (!$data['user']) {
            return redirect(route('home'))->withErrors(__('item_404', ['item' => 'User']));
        }
        if ($request->user() && $data['user']->id == $request->user()->id) {
            $data['author'] = true;
        } else {
            $data['author'] = null;
        }

        $data['comments_count'] = $data['user']->comments->count();
        $data['posts_count'] = $data['user']->posts->count();
        $data['posts_active_count'] = $data['user']->posts->where('active', '1')->count();
        $data['posts_draft_count'] = $data['posts_count'] - $data['posts_active_count'];
        $data['latest_posts'] = $data['user']->posts->where('active', '1')->take(5);
        $data['latest_comments'] = Comment::where('user_id', $data['user']->id)->with('post')->take(5)->get();

        return view('profile', ['data' => $data]);
    }
}
