<?php

namespace App\Traits;

use App\Http\Controllers\TagController;
use App\Http\Requests\PostFormRequest;
use App\Models\Post;
use Illuminate\Http\Request;

trait Content
{

    // post type urls for listing all content
    public $post_type_plurals = [
        'page' => 'pages',
        'post' => 'posts',
    ];

    /**
     * Shows list of posts
     *
     * @return view
     */
    public function adminList()
    {
        $posts = Post::where('post_type', $this->post_type)->paginate(5);

        return view("admin/{$this->post_type}/list", [
            'posts' => $posts,
            'post_type' => $this->post_type,
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

        $values['user_id'] = $request->user()->id;

        if ($request->has('save')) {
            $values['active'] = 0;
            $message = __('messages.item_saved', ['item' => 'Post']);
        } else {
            $values['active'] = 1;
            $message = __('messages.item_published', ['item' => 'Post']);
        }

        Post::create($values);

        return redirect(route("admin/{$this->post_type}/list"))->withMessage($message);
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

        // continue editing
        if ($request->has('save')) {
            $message = __('messages.item_saved', ['item' => 'Post']);
            $route = "admin/{$this->post_type}";

        // finish editing, return to posts
        } else {
            $post->active = 1;
            $message = __('messages.item_updated', ['item' => 'Post']);
            $route = "admin/{$this->post_type}/list";
        }
        $post->update($values);
        if ($request->tags) {
            TagController::save($post_id, $request->tags);
        }

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

        return redirect(route("admin/{$this->post_type}/list"))->with($data);
    }

    /**
     * Shows edit form
     *
     * @param int $id
     * @return view
     */
    public function editContent($id)
    {
        $post = Post::where('id', $id)->with('tags')->first();

        if (!$post) {
            return redirect(route("admin/{$this->post_type}/list"))
                ->withErrors(__('messages.post_doesnt_exist'));
        }

        return view("admin/{$this->post_type}/edit", [
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
            return view("admin/{$this->post_type}/new", ['post_type' => $this->post_type]);

        } else {
            return redirect(route("admin/{$this->post_type}/list"))
                ->withErrors(__('messages.no_permission_writing_post'));
        }
    }
}
