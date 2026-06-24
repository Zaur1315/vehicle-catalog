<?php

declare(strict_types=1);

namespace App\Filament\Resources\Leads\Schemas;

use App\Models\Lead;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class LeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Lead details')
                    ->schema([
                        Select::make('type')
                            ->required()
                            ->options([
                                Lead::TYPE_VEHICLE_INQUIRY => 'Vehicle inquiry',
                                Lead::TYPE_CONTACT => 'Contact',
                                Lead::TYPE_FINANCE => 'Finance',
                                Lead::TYPE_TRADE_IN => 'Trade-in',
                            ])
                            ->default(Lead::TYPE_CONTACT),

                        Select::make('vehicle_id')
                            ->label('Vehicle')
                            ->relationship('vehicle', 'name')
                            ->searchable()
                            ->preload(),

                        Select::make('status')
                            ->required()
                            ->options([
                                Lead::STATUS_NEW => 'New',
                                Lead::STATUS_CONTACTED => 'Contacted',
                                Lead::STATUS_QUALIFIED => 'Qualified',
                                Lead::STATUS_CLOSED => 'Closed',
                                Lead::STATUS_SPAM => 'Spam',
                            ])
                            ->default(Lead::STATUS_NEW),

                        TextInput::make('source')
                            ->required()
                            ->default('website')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Customer information')
                    ->schema([
                        TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('last_name')
                            ->maxLength(255),

                        TextInput::make('email')
                            ->email()
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->required()
                            ->tel()
                            ->maxLength(255),

                        TextInput::make('preferred_contact_time')
                            ->label('Preferred contact time')
                            ->maxLength(255),

                        TextInput::make('subject')
                            ->maxLength(255),

                        Textarea::make('message')
                            ->rows(5)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Additional data')
                    ->schema([
                        KeyValue::make('payload')
                            ->label('Payload')
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),
                    ])
                    ->visible(static fn ($record): bool => $record !== null && filled($record->payload)),
            ]);
    }
}
