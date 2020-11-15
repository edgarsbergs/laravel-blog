<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    // post can be edited by its author or admin
    public function edit(User $user, Post $post)
    {
        return ($post->user_id == $user->id || $user->is_admin());
    }
}
