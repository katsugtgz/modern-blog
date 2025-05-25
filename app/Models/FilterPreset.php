<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FilterPreset extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'categories',
        'tags',
        'date_range',
        'authors',
        'sort_by',
        'additional_filters',
    ];

    protected $casts = [
        'categories' => 'array',
        'tags' => 'array',
        'date_range' => 'array',
        'authors' => 'array',
        'sort_by' => 'array',
        'additional_filters' => 'array',
    ];

    /**
     * Get the user that owns the filter preset.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
