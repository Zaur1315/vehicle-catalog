<?php

declare(strict_types=1);

namespace App\Filament\Resources\Vehicles\Tables;

use App\Models\Vehicle;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

final class VehiclesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('main_image_url')
                    ->label('Image')
                    ->getStateUsing(static fn(Vehicle $record): string => $record->main_image_url)
                    ->square(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('stock_number')
                    ->label('Stock #')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('vin')
                    ->label('VIN')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('make.name')
                    ->label('Make')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('vehicleModel.name')
                    ->label('Model')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('year')
                    ->sortable(),

                TextColumn::make('price')
                    ->money('USD')
                    ->sortable()
                    ->placeholder('On request'),

                TextColumn::make('mileage')
                    ->numeric()
                    ->suffix(' mi')
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('condition')
                    ->badge()
                    ->formatStateUsing(static fn(?string $state): string => match ($state) {
                        Vehicle::CONDITION_NEW => 'New',
                        Vehicle::CONDITION_USED => 'Used',
                        Vehicle::CONDITION_CERTIFIED => 'Certified',
                        default => '-',
                    })
                    ->color(static fn(?string $state): string => match ($state) {
                        Vehicle::CONDITION_NEW => 'success',
                        Vehicle::CONDITION_USED => 'warning',
                        Vehicle::CONDITION_CERTIFIED => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(static fn(?string $state): string => match ($state) {
                        Vehicle::STATUS_DRAFT => 'Draft',
                        Vehicle::STATUS_AVAILABLE => 'Available',
                        Vehicle::STATUS_PENDING => 'Pending',
                        Vehicle::STATUS_SOLD => 'Sold',
                        default => '-',
                    })
                    ->color(static fn(?string $state): string => match ($state) {
                        Vehicle::STATUS_DRAFT => 'gray',
                        Vehicle::STATUS_AVAILABLE => 'success',
                        Vehicle::STATUS_PENDING => 'warning',
                        Vehicle::STATUS_SOLD => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('vehicle_make_id')
                    ->label('Make')
                    ->relationship('make', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('vehicle_model_id')
                    ->label('Model')
                    ->relationship('vehicleModel', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('condition')
                    ->options([
                        Vehicle::CONDITION_NEW => 'New',
                        Vehicle::CONDITION_USED => 'Used',
                        Vehicle::CONDITION_CERTIFIED => 'Certified',
                    ]),

                SelectFilter::make('status')
                    ->options([
                        Vehicle::STATUS_DRAFT => 'Draft',
                        Vehicle::STATUS_AVAILABLE => 'Available',
                        Vehicle::STATUS_PENDING => 'Pending',
                        Vehicle::STATUS_SOLD => 'Sold',
                    ]),

                TernaryFilter::make('is_featured')
                    ->label('Featured'),

                TernaryFilter::make('is_active')
                    ->label('Active'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
