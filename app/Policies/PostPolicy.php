<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function edit(User $user, Post $post)
    {
        return ($post->user_id == $user->id || $user->is_admin());
    }
}
