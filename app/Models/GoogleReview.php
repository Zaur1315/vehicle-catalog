<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class GoogleReview extends Model
{
    protected $fillable = [
        'google_review_name',
        'author_name',
        'author_url',
        'author_photo_url',
        'rating',
        'text',
        'relative_time_description',
        'published_at',
        'is_active',
        'sort_order',
        'payload',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'published_at' => 'datetime',
            'is_active' => 'boolean',
            'payload' => 'array',
        ];
    }
}
