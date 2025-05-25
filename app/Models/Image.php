<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'path',
        'original_filename',
        'alt_text',
        'caption',
        'sort_order',
        'mime_type',
        'size_in_kb',
        'width',
        'height',
    ];

    /**
     * Get the post that owns the image.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get full URL for the image.
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }

    /**
     * Get thumbnail URL for the image.
     */
    public function getThumbnailUrlAttribute(): string
    {
        $path_parts = pathinfo($this->path);
        $thumbnail_path = $path_parts['dirname'] . '/thumbnails/' . $path_parts['basename'];
        
        return asset('storage/' . $thumbnail_path);
    }
}
