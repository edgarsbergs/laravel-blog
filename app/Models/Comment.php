<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    // author of comment
    public function author()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    // post of comment
    public function post()
    {
        return $this->belongsTo('App\Models\Post', 'post_id');
    }
}
