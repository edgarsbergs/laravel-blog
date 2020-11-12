<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Http\Requests\PostFormRequest;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('active', 1)
                        ->orderBy('created_at','desc')
                        ->paginate(5);

        return view('home', [
            'posts' => $posts,
        ]);
    }

    /**
     * Saves or publishes post
     *
     * @param object $request
     * @return resource
     */
    public function store(PostFormRequest $request)
    {
        $post = new Post();
        $post->title = $request->get('title');
        $post->body = $request->get('body');
        $post->slug = Str::slug($post->title);

        $post_exists = Post::where('slug', $post->slug)->first();
        if ($post_exists) {
            return redirect(route('newPost'))->withErrors(__('messages.post_title_exists'))->withInput();
        }

        $post->user_id = $request->user()->id;
        if ($request->has('save')) {
            $post->active = 0;
            $message = __('messages.item_saved', ['item' => 'Post']);

        } else {
            $post->active = 1;
            $message = __('messages.item_published', ['item' => 'Post']);
        }
        $post->save();

        return redirect(route('admin/posts'))->withMessage($message);
    }

    /**
     * Shows post
     *
     * @param string $slug
     * @return view
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();
        if (!$post) {
            return redirect('/')->withErrors(__('messages.page_404'));
        }
        $comments = $post->comments;

        return view('posts.show', [
            'meta_title' => $post['title'],
            'comments' => $comments,
            'post' => $post,
        ]);
    }

    /**
     * Updates post
     *
     * @param object $request
     * @return resource
     */
    public function updatePost(Request $request)
    {
        $post_id = $request->input('post_id');
        $post = Post::find($post_id);

        if ($post && ($post->user_id == $request->user()->id || $request->user()->is_admin())) {
            $title = $request->input('title');
            $slug = Str::slug($title);
            $exists = Post::where('slug', $slug)->first();

            if ($exists) {
                if ($exists->id != $post_id) {
                    return redirect('edit/' . $post->slug)->withErrors(__('messages.post_title_exists'))->withInput();
                } else {
                    $post->slug = $slug;
                }
            }

            $post->title = $title;
            $post->body = $request->input('body');

            if ($request->has('save')) {
                $post->active = 0;
                $message = __('messages.item_saved', ['item' => 'Post']);
                $route = 'admin/post';
            } else {
                $post->active = 1;
                $message = __('messages.item_updated', ['item' => 'Post']);
                $route = 'admin/posts';
            }
            $post->save();

            return redirect(route( $route, $post->id))->withMessage($message);

        } else {
            return redirect(route('newPost'))->withErrors(__('messages.no_permission'))->withInput();
        }
    }

    /**
     * Deletes post
     *
     * @param object $request
     * @param int $id
     * @return resource
     */
    public function destroy(Request $request, $id)
    {
        $post = Post::find($id);
        if ($post && ($post->user_id == $request->user()->id || $request->user()->is_admin())) {
            $post->delete();
            $data['message'] = __('messages.deleted_success', ['item' => 'Post']);

        } else {
            $data['errors'] = __('messages.no_permission');
        }

        return redirect(route('admin/posts'))->with($data);
    }
}
