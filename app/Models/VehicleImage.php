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
            return asset('images/placeholders/vehicle-placeholder.svg');
        }

        if (str_starts_with($this->path, 'http://') || str_starts_with($this->path, 'https://')) {
            return $this->path;
        }

        $path = ltrim($this->path, '/');
        $publicPath = str_starts_with($path, 'images/') ? $path : 'images/'.$path;

        if (is_file(public_path($publicPath))) {
            return asset($publicPath);
        }

        return asset('storage/'.ltrim($this->path, '/'));
    }
}
