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
        // latest active posts
        $posts = Post::where('active', 1)
                        ->orderBy('created_at','desc')
                        ->paginate(5);

        $title = 'Latest Posts';

        return view('home', [
            'posts' => $posts,
            'title' => $title,
        ]);
    }

    // show form for creating post
    public function create(Request $request)
    {
        if ($request->user()->can_post()) {
            return view('posts/create');

        } else {
            return redirect('/')->withErrors('You have not sufficient permissions for writing post');
        }
    }

    // save of publish post
    public function store(PostFormRequest $request)
    {
        $post = new Post();
        $post->title = $request->get('title');
        $post->body = $request->get('body');
        $post->slug = Str::slug($post->title);

        $post_exists = Post::where('slug', $post->slug)->first();
        if ($post_exists) {
            return redirect('new-post')->withErrors('Post with that title already exists.')->withInput();
        }

        $post->user_id = $request->user()->id;
        if ($request->has('save')) {
            $post->active = 0;
            $message = 'Post saved successfully';
        } else {
            $post->active = 1;
            $message = 'Post published successfully';
        }
        $post->save();

        return redirect('edit/' . $post->slug)->withMessage($message);
    }

    // @TODO fix: shows when after registering
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();
        if (!$post) {
            return redirect('/')->withErrors('requested page not found');
        }
        $comments = $post->comments;

        return view('posts.show', [
            'meta_title' => $post['title'],
            'comments' => $comments,
            'post' => $post,
        ]);
    }

    // show post edit form
    public function edit(Request $request,$slug)
    {
        $post = Post::where('slug', $slug)->first();
        if (!$post) {
            return redirect('/')->withErrors('post does not exist!');
        }

        if ($request->user()->id == $post->user_id || $request->user()->is_admin()) {
            return view('posts/edit')->with('post', $post);
        }

        return redirect('/')->withErrors('you have not sufficient permissions');
    }

    public function update(Request $request)
    {
        $post_id = $request->input('post_id');
        $post = Post::find($post_id);

        if ($post && ($post->user_id == $request->user()->id || $request->user()->is_admin())) {
            $title = $request->input('title');
            $slug = Str::slug($title);
            $exists = Post::where('slug', $slug)->first();

            if ($exists) {
                if ($exists->id != $post_id) {
                    return redirect('edit/' . $post->slug)->withErrors('Title already exists.')->withInput();
                } else {
                    $post->slug = $slug;
                }
            }

            $post->title = $title;
            $post->body = $request->input('body');

            if ($request->has('save')) {
                $post->active = 0;
                $message = 'Post saved successfully';
                $landing = 'edit/' . $post->slug;
            } else {
                $post->active = 1;
                $message = 'Post updated successfully';
                $landing = $post->slug;
            }
            $post->save();
            return redirect($landing)->withMessage($message);

        } else {
            return redirect('/')->withErrors('you have not sufficient permissions');
        }
    }

    public function destroy(Request $request, $id)
    {
        $post = Posts::find($id);
        if ($post && ($post->user_id == $request->user()->id || $request->user()->is_admin())) {
            $post->delete();
            $data['message'] = 'Post deleted Successfully';

        } else {
            $data['errors'] = 'Invalid Operation. You have not sufficient permissions';
        }

        return redirect('/')->with($data);
    }
}
