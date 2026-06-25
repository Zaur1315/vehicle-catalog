<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

final class Vehicle extends Model
{
    public const CONDITION_NEW = 'new';
    public const CONDITION_USED = 'used';
    public const CONDITION_CERTIFIED = 'certified';

    public const STATUS_DRAFT = 'draft';
    public const STATUS_AVAILABLE = 'available';
    public const STATUS_PENDING = 'pending';
    public const STATUS_SOLD = 'sold';

    protected $fillable = [
        'vehicle_make_id',
        'vehicle_model_id',
        'name',
        'slug',
        'stock_number',
        'vin',
        'year',
        'price',
        'price_on_request',
        'mileage',
        'condition',
        'body_type',
        'transmission',
        'drivetrain',
        'engine',
        'fuel_type',
        'exterior_color',
        'interior_color',
        'short_description',
        'description',
        'features',
        'main_image',
        'status',
        'is_featured',
        'is_active',
        'published_at',
        'seo_title',
        'seo_description',
    ];

    protected $casts = [
        'vehicle_make_id' => 'integer',
        'vehicle_model_id' => 'integer',
        'year' => 'integer',
        'price' => 'decimal:2',
        'price_on_request' => 'boolean',
        'mileage' => 'integer',
        'features' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function make(): BelongsTo
    {
        return $this->belongsTo(VehicleMake::class, 'vehicle_make_id');
    }

    public function vehicleModel(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, 'vehicle_model_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(VehicleImage::class)->orderBy('sort_order');
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->price_on_request || $this->price === null) {
            return 'Price on request';
        }

        return '$' . number_format((float) $this->price, 2);
    }

    public function getFormattedMileageAttribute(): string
    {
        if ($this->mileage === null) {
            return '-';
        }

        return number_format($this->mileage) . ' mi';
    }

    public function getMainImageUrlAttribute(): string
    {
        if ($this->main_image === null || $this->main_image === '') {
            return asset('images/placeholders/vehicle-placeholder.jpg');
        }

        if (str_starts_with($this->main_image, 'http://') || str_starts_with($this->main_image, 'https://')) {
            return $this->main_image;
        }

        if (str_starts_with($this->main_image, 'images/')) {
            return asset($this->main_image);
        }

        return asset('storage/' . ltrim($this->main_image, '/'));
    }

    public function getMainImageThumbUrlAttribute(): ?string
    {
        if (! $this->main_image) {
            return null;
        }

        $thumbPath = str_replace('/large/', '/thumb/', $this->main_image);

        if (Storage::disk('public')->exists($thumbPath)) {
            return Storage::url($thumbPath);
        }

        return Storage::url($this->main_image);
    }
}
