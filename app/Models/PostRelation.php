<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostRelation extends Model
{
    use HasFactory;

    // user may have tags
    public function tags()
    {
        return $this->hasMany('App\Models\Tag', 'post_id');
    }

    // belongs to posts
    public function posts()
    {
        return $this->belongsToMany('App\Models\Post');
    }
}
