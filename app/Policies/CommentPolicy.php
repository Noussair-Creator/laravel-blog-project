<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    /**
     * This 'before' method gives admins a "superuser" key.
     * It runs before any other method in the policy.
     */
    public function before(User $user, string $ability): bool|null
    {
        // Check for a permission that only admins have.
        if ($user->can('delete any comment')) {
            return true;
        }

        return null; // Let the other methods decide
    }

    /**
     * Determine whether the user can create models.
     * Any authenticated user can create a comment.
     */
    public function create(User $user): bool
    {
        return $user->exists();
    }

    /**
     * Determine whether the user can delete the model.
     * The 'before' method already handles admins. This method only needs
     * to check for ownership for regular users.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }
}