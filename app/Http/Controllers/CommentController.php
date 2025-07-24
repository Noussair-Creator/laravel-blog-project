<?php
// app/Http/Controllers/CommentController.php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\CommentStoreRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentStoreRequest $request)
    {
        // This authorization check is not needed here because the 'auth' middleware
        // on the route already ensures the user is logged in. The policy's create
        // method just checks for an authenticated user, which is redundant.
        // $this->authorize('create', Comment::class);

        $data = $request->validated();
        $data['user_id'] = auth()->id();

        Comment::create($data);

        // Change the return type from JSON to a redirect.
        // This will send the user back to the previous page (the post show page).
        return redirect()->back()->with('success', 'Your comment has been posted!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        // Also change this return type to a redirect.
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
