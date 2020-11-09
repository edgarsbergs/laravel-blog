<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    // user may have comments
    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'post_id');
    }

    // post is made by user
    public function author()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
