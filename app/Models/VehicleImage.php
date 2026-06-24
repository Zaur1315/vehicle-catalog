<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class VehicleImage extends Model
{
    protected $fillable = [
        'vehicle_id',
        'path',
        'alt',
        'sort_order',
        'is_main',
    ];

    protected $casts = [
        'vehicle_id' => 'integer',
        'sort_order' => 'integer',
        'is_main' => 'boolean',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function getUrlAttribute(): string
    {
        if ($this->path === null || $this->path === '') {
            return asset('images/placeholders/vehicle-placeholder.jpg');
        }

        if (str_starts_with($this->path, 'http://') || str_starts_with($this->path, 'https://')) {
            return $this->path;
        }

        if (str_starts_with($this->path, 'images/')) {
            return asset($this->path);
        }

        return asset('storage/' . ltrim($this->path, '/'));
    }
}
