<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * This 'before' method gives admins a "superuser" key.
     * It runs before any other method in the policy.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return null; // Let the other methods decide
    }

    /**
     * Determine whether the user can view any models.
     * For now, we'll say only admins can see the full list in the admin panel.
     * The public list will be handled by a different controller later.
     */
    public function viewAny(User $user): bool
    {
        // This is for the admin index page. The before() method handles admins.
        return false;
    }

    /**
     * Determine whether the user can view the model.
     * Anyone can view a single published post, but for the admin panel, let's restrict it.
     */
    public function view(User $user, Post $post): bool
    {
        // This is for the admin show page. The before() method handles admins.
        return false;
    }

    /**
     * Determine whether the user can create models.
     * A user can create a post if they have the 'create posts' permission.
     */
    public function create(User $user): bool
    {
        return $user->can('create posts');
    }

    /**
     * Determine whether the user can update the model.
     * A user can update a post if they have the 'edit own posts' permission AND they own the post.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->can('edit own posts') && $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     * A user can delete a post if they have the 'delete own posts' permission AND they own the post.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->can('delete own posts') && $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        // For now, only admins can restore (handled by before() method)
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        // For now, only admins can force delete (handled by before() method)
        return false;
    }
}
