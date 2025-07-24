<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Category; // <-- Import the Category model
use App\Models\Post;
use App\Policies\CategoryPolicy; // <-- Import the CategoryPolicy
use App\Policies\PostPolicy;
use App\Models\Comment; // <-- Import the Comment model
use App\Policies\CommentPolicy; // <-- Import the CommentPolicy

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
            // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Category::class => CategoryPolicy::class, // <-- Add this line
        Post::class => PostPolicy::class, // <-- Add this line
        Comment::class => CommentPolicy::class, // <-- Add this line
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
