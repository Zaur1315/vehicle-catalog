<?php

declare(strict_types=1);

namespace App\Filament\Resources\Vehicles\Schemas;

use App\Models\Vehicle;
use App\Models\VehicleModel;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

final class VehicleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Main information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                static function (string $operation, ?string $state, callable $set): void {
                                    if ($operation !== 'create' || $state === null) {
                                        return;
                                    }

                                    $set('slug', Str::slug($state));
                                }
                            ),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        TextInput::make('stock_number')
                            ->label('Stock #')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        TextInput::make('vin')
                            ->label('VIN')
                            ->maxLength(32)
                            ->unique(ignoreRecord: true),

                        Select::make('vehicle_make_id')
                            ->label('Make')
                            ->relationship('make', 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(static fn(callable $set): mixed => $set('vehicle_model_id', null))
                            ->required(),

                        Select::make('vehicle_model_id')
                            ->label('Model')
                            ->options(static function (callable $get): array {
                                $makeId = $get('vehicle_make_id');

                                if ($makeId === null) {
                                    return [];
                                }

                                return VehicleModel::query()
                                    ->where('vehicle_make_id', $makeId)
                                    ->where('is_active', true)
                                    ->orderBy('sort_order')
                                    ->orderBy('name')
                                    ->pluck('name', 'id')
                                    ->all();
                            })
                            ->searchable()
                            ->preload()
                            ->required(),

                        Textarea::make('short_description')
                            ->rows(3)
                            ->columnSpanFull(),

                        RichEditor::make('description')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Pricing')
                    ->schema([
                        TextInput::make('price')
                            ->numeric()
                            ->prefix('$')
                            ->minValue(0)
                            ->step('0.01'),

                        Toggle::make('price_on_request')
                            ->label('Price on request')
                            ->default(false),
                    ])
                    ->columns(2),

                Section::make('Vehicle details')
                    ->schema([
                        TextInput::make('year')
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue((int) date('Y') + 1),

                        TextInput::make('mileage')
                            ->numeric()
                            ->minValue(0),

                        Select::make('condition')
                            ->options([
                                Vehicle::CONDITION_NEW => 'New',
                                Vehicle::CONDITION_USED => 'Used',
                                Vehicle::CONDITION_CERTIFIED => 'Certified',
                            ])
                            ->default(Vehicle::CONDITION_USED)
                            ->required(),

                        Select::make('body_type')
                            ->options([
                                'sedan' => 'Sedan',
                                'suv' => 'SUV',
                                'coupe' => 'Coupe',
                                'truck' => 'Truck',
                                'hatchback' => 'Hatchback',
                                'van' => 'Van',
                                'wagon' => 'Wagon',
                                'convertible' => 'Convertible',
                            ])
                            ->searchable(),

                        Select::make('transmission')
                            ->options([
                                'automatic' => 'Automatic',
                                'manual' => 'Manual',
                                'cvt' => 'CVT',
                            ])
                            ->searchable(),

                        Select::make('drivetrain')
                            ->options([
                                'fwd' => 'FWD',
                                'rwd' => 'RWD',
                                'awd' => 'AWD',
                                '4wd' => '4WD',
                            ])
                            ->searchable(),

                        TextInput::make('engine')
                            ->maxLength(255),

                        Select::make('fuel_type')
                            ->options([
                                'gasoline' => 'Gasoline',
                                'diesel' => 'Diesel',
                                'hybrid' => 'Hybrid',
                                'electric' => 'Electric',
                                'plug_in_hybrid' => 'Plug-in Hybrid',
                            ])
                            ->searchable(),

                        TextInput::make('exterior_color')
                            ->maxLength(255),

                        TextInput::make('interior_color')
                            ->maxLength(255),
                    ])
                    ->columns(3),

                Section::make('Images')
                    ->schema([
                        FileUpload::make('main_image')
                            ->label('Main image')
                            ->image()
                            ->directory('vehicles/main')
                            ->visibility('public')
                            ->disk('public')
                            ->columnSpanFull(),

                        Repeater::make('images')
                            ->relationship('images')
                            ->schema([
                                FileUpload::make('path')
                                    ->label('Image')
                                    ->image()
                                    ->directory('vehicles/gallery')
                                    ->visibility('public')
                                    ->disk('public')
                                    ->required(),

                                TextInput::make('alt')
                                    ->label('Alt text')
                                    ->maxLength(255),

                                TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0),

                                Toggle::make('is_main')
                                    ->label('Main'),
                            ])
                            ->columns(4)
                            ->defaultItems(0)
                            ->columnSpanFull(),
                    ]),

                Section::make('Features')
                    ->schema([
                        Repeater::make('features')
                            ->schema([
                                TextInput::make('label')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->columns(1)
                            ->defaultItems(0)
                            ->columnSpanFull(),
                    ]),

                Section::make('Publishing')
                    ->schema([
                        Select::make('status')
                            ->options([
                                Vehicle::STATUS_DRAFT => 'Draft',
                                Vehicle::STATUS_AVAILABLE => 'Available',
                                Vehicle::STATUS_PENDING => 'Pending',
                                Vehicle::STATUS_SOLD => 'Sold',
                            ])
                            ->default(Vehicle::STATUS_AVAILABLE)
                            ->required(),

                        Toggle::make('is_featured')
                            ->label('Featured')
                            ->default(false),

                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(3),

                Section::make('SEO')
                    ->schema([
                        TextInput::make('seo_title')
                            ->maxLength(255),

                        Textarea::make('seo_description')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
