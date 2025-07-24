<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <-- Import the Storage facade

class PostController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Post::class);

        // Use paginate for better performance
        $posts = Post::with('user', 'category')->latest()->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $this->authorize('create', Post::class);

        // Pass all categories to the view for the dropdown
        $categories = Category::all();

        return view('admin.posts.create', compact('categories'));
    }

    public function store(PostStoreRequest $request)
    {
        $this->authorize('create', Post::class);

        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('feature_image')) {
            $data['feature_image'] = $request->file('feature_image')->store('images', 'public');
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        $this->authorize('view', $post);
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        // Also pass categories to the edit view
        $categories = Category::all();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(PostUpdateRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $data = $request->validated();

        if ($request->hasFile('feature_image')) {
            // Delete the old image if it exists
            if ($post->feature_image) {
                Storage::disk('public')->delete($post->feature_image);
            }
            // Store the new image
            $data['feature_image'] = $request->file('feature_image')->store('images', 'public');
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        // Delete the associated image from storage before deleting the post
        if ($post->feature_image) {
            Storage::disk('public')->delete($post->feature_image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }
}
