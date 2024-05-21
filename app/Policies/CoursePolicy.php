<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function view(?User $user, Course $post)
    {
        if ($post->published) {
            return true;
        }

        // visitors cannot view unpublished items
        if ($user === null) {
            return false;
        }

        // admin overrides published status
        if ($user->can('view unpublished posts')) {
            return true;
        }

        // authors can view their own unpublished posts
        return $user->id == $post->user_id;
    }

    public function create(User $user)
    {
        return ($user->can('create posts'));
    }

    public function update(User $user, Course $post)
    {
        if ($user->can('edit own posts')) {
            return $user->id == $post->user_id;
        }

        if ($user->can('edit all posts')) {
            return true;
        }
    }

    public function delete(User $user, Course $post)
    {
        if ($user->can('delete own posts')) {
            return $user->id == $post->user_id;
        }

        if ($user->can('delete any post')) {
            return true;
        }
    }
}
