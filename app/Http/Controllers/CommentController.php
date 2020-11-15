<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Creates comment
     *
     * @param object $request
     * @return resource
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'body' => 'required',
        ]);
        $validated['user_id'] = $request->user()->id;
        $validated['post_id'] = $request->input('post_id');
        Comment::create( $validated );

        $slug = $request->input('slug');

        return redirect($slug)->with('message', __('messages.item_published', ['item' => 'Comment']));
    }
}
