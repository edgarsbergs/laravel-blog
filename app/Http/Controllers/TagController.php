<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Shows tag page
     *
     * @param string $slug
     * @return resource
     */
    public function show($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $relations = $tag->relations->pluck('post_id');
        $posts = Post::whereIn('id', $relations)->get();

        return view('tag', [
            'tag' => $tag,
            'posts' => $posts,
        ]);
    }

    /**
     * Saves tags
     *
     */
    public static function store($post_id, $tags)
    {
        //save tags
        $values = [];
        foreach ($tags as $tag) {
            $values []= [
                'title' => $tag,
                'slug' => Str::slug($tag),
            ];
        }
        DB::table('tags')->insertOrIgnore($values);

        //save relations to post

    }
}
