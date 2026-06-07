<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'blog_title',
        'blog_slug',
        'blog_category',
        'blog_date',
        'blog_author',
        'blog_description',
        'blog_image',
        'blog_tags',
        'is_active',
        'is_featured',
        'is_main_featured',
    ];

    // Optional: type casting
    protected $casts = [
        'blog_date' => 'date',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_main_featured' => 'boolean',
    ];

    // Always include a ready-to-use full image URL in API responses.
    protected $appends = ['blog_image_url'];

    public function getBlogImageUrlAttribute(): ?string
    {
        return $this->blog_image ? asset($this->blog_image) : null;
    }
}