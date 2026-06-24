<?php

declare(strict_types=1);

namespace App\Filament\Resources\VehicleModels\Pages;

use App\Filament\Resources\VehicleModels\VehicleModelResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateVehicleModel extends CreateRecord
{
    protected static string $resource = VehicleModelResource::class;
}
