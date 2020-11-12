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
        $input['user_id'] = $request->user()->id;
        $input['post_id'] = $request->input('post_id');
        $input['body'] = $request->input('body');
        $slug = $request->input('slug');
        Comment::create( $input );

        return redirect($slug)->with('message', __('messages.item_published', ['item' => 'Comment']));
    }
}
