<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Http\Requests\PostFormRequest;
use App\Http\Controllers\TagController;
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
     * @param PostFormRequest $request
     * @return resource
     */
    public function store(PostFormRequest $request)
    {
        $values = $request->validate([
            'title' => 'required|unique:posts',
            'body' => 'required',
        ]);

        $values['slug'] = Str::slug($values['title']);
        $values['user_id'] = $request->user()->id;

        if ($request->has('save')) {
            $values['active'] = 0;
            $message = __('messages.item_saved', ['item' => 'Post']);
        } else {
            $values['active'] = 1;
            $message = __('messages.item_published', ['item' => 'Post']);
        }

        Post::create($values);

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
        $post = Post::where('slug', $slug)->with('tags')->first();
        if (!$post) {
            return redirect('/')->withErrors(__('messages.page_404'));
        }
        $comments = $post->comments;
        $tags = $post->tags;

        return view('posts.show', [
            'meta_title' => $post['title'],
            'comments' => $comments,
            'post' => $post,
            'tags' => $tags,
        ]);
    }

    /**
     * Updates post
     *
     * @param Request $request
     * @return resource
     */
    public function updatePost(Request $request)
    {
        $post_id = $request->input('post_id');
        $post = Post::find($post_id);

        if ($request->user()->cannot('edit', $post)) {
            return redirect(route('newPost'))->withErrors(__('messages.no_permission'))->withInput();
        }

        $values = $request->validate([
            'title' => "required|unique:posts,title,{$post->title},title",
            'body' => 'required',
        ]);
        $values['slug'] = Str::slug($values['title']);

        // continue editing
        if ($request->has('save')) {
            $message = __('messages.item_saved', ['item' => 'Post']);
            $route = 'admin/post';

        // finish editing, return to posts
        } else {
            $post->active = 1;
            $message = __('messages.item_updated', ['item' => 'Post']);
            $route = 'admin/posts';
        }
        $post->update($values);
        TagController::store($post_id, $request->tags);

        return redirect(route( $route, $post->id))->withMessage($message);
    }

    /**
     * Deletes post
     *
     * @param Request $request
     * @param int $id
     * @return resource
     */
    public function destroy(Request $request, $id)
    {
        $post = Post::find($id);
        if ($post && $request->user()->can('edit', $post)) {
            $post->delete();
            $data['message'] = __('messages.deleted_success', ['item' => 'Post']);

        } else {
            $data['errors'] = __('messages.no_permission');
        }

        return redirect(route('admin/posts'))->with($data);
    }
}
