<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Blog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'blog_title',
        'blog_slug',
        'blog_category',
        'blog_date',
        'blog_author',
        'author_id',
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
        if (! $this->blog_image) {
            return null;
        }

        // A stored remote URL is returned as-is; a local path gets the full asset() URL.
        return Str::startsWith($this->blog_image, ['http://', 'https://'])
            ? $this->blog_image
            : asset($this->blog_image);
    }
}