<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    // post may have comments
    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'post_id');
    }

    // post may have tags
    public function tags()
    {
        return $this->hasManyThrough('App\Models\Tag', 'App\Models\PostRelation', 'post_id', 'id' ,'id' ,'ref_id')
            ->where('ref_type', 'tag');
    }

    // post is made by user
    public function author()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
