<?php

namespace App\Http\Controllers;

use App\Models\PostRelation;
use Illuminate\Http\Request;

class PostRelationController extends Controller
{
    /**
     * Saves post relations
     *
     * @param int $post_id
     * @param string $ref_type
     * @param array $values
     *
     */
    public static function create($post_id, $ref_type, $values)
    {
        $insert = [];
        foreach ($values as $key => $value) {
            $insert[$key]['ref_id'] = $value['id'];
            $insert[$key]['ref_type'] = $ref_type;
            $insert[$key]['post_id'] = $post_id;

        }

        PostRelation::insertOrIgnore($insert);
    }
}
