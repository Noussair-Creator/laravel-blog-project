<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // For the main blog page, it's more efficient to just get the user and category.
        // We also add pagination and order by the newest posts first.
        $posts = Post::with('user', 'category')->latest()->paginate(9);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Authorize that the user is allowed to create posts.
        $this->authorize('create', Post::class);

        // We need to pass the categories to the view for the dropdown.
        $categories = Category::all();

        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        $this->authorize('create', Post::class);

        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('feature_image')) {
            $data['feature_image'] = $request->file('feature_image')->store('images', 'public');
        }

        $post = Post::create($data);

        // Redirect to the new post's show page instead of the index.
        return redirect()->route('posts.show', $post)->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // Eager load the comments AND the user of each comment to prevent N+1 problem.
        $post->load(['user', 'category', 'comments.user']);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // Authorize that the user can update THIS specific post.
        $this->authorize('update', $post);

        $categories = Category::all();

        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $data = $request->validated();

        if ($request->hasFile('feature_image')) {
            // Delete the old image if it exists
            if ($post->feature_image) {
                Storage::disk('public')->delete($post->feature_image);
            }
            $data['feature_image'] = $request->file('feature_image')->store('images', 'public');
        }

        $post->update($data);

        return redirect()->route('posts.show', $post)->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Authorize that the user can delete THIS specific post.
        $this->authorize('delete', $post);

        // Delete the image from storage first
        if ($post->feature_image) {
            Storage::disk('public')->delete($post->feature_image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
