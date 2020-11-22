<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Traits\Content;

class PageController extends Controller
{
    use Content;

    protected $post_type;

    public function __construct()
    {
        $this->post_type = 'page';
    }

}
