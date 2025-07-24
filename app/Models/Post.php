<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str; // <-- Import the Str helper

class Post extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['title', 'slug', 'content', 'feature_image', 'user_id', 'category_id'];


    /**
     * The "booted" method of the model.
     * This will automatically create a slug from the title before saving.
     */
    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            $post->slug = Str::slug($post->title);
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}