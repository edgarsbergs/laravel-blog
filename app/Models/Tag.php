<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    // belongs to relations
    public function relations()
    {
        return $this->belongsToMany('App\Models\PostRelation', 'tags', 'id', 'id', '' ,'ref_id')
            ->where('ref_type', 'tag');
    }
}
