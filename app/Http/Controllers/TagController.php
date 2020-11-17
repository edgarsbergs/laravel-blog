<?php

namespace App\Http\Controllers;

use App\Models\PostRelation;
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
     * Saves, updates or removes tags
     *
     * @param int $post_id
     * @param array $tags
     */
    public static function save($post_id, $tags)
    {
        //save all tags @TODO save only non-existing
        $values = [];
        foreach ($tags as $tag) {
            $values []= [
                'title' => $tag,
                'slug' => Str::slug($tag),
            ];
        }
        Tag::insertOrIgnore($values);

        // get tag ids
        $tags_ids = Tag::whereIn('title', $tags)->get('id')->toArray();

        // save relations
        PostRelationController::create($post_id, 'tag', $tags_ids);

        // delete unused tag relations
        // @TODO delete if all tags removed
        PostRelation::where('post_id', $post_id)->where('ref_type', '=', 'tag')
            ->whereNotIn('ref_id', $tags_ids)->delete();
    }
}
