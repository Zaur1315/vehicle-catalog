<?php

declare(strict_types=1);

namespace App\Filament\Resources\VehicleMakes\Pages;

use App\Filament\Resources\VehicleMakes\VehicleMakeResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateVehicleMake extends CreateRecord
{
    protected static string $resource = VehicleMakeResource::class;
}
