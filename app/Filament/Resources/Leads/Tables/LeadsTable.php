<?php

declare(strict_types=1);

namespace App\Filament\Resources\Leads\Tables;

use App\Models\Lead;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

final class LeadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer_name')
                    ->label('Customer')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(['first_name']),

                TextColumn::make('phone')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->placeholder('-'),

                TextColumn::make('vehicle.name')
                    ->label('Vehicle')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(static fn(?string $state): string => match ($state) {
                        Lead::TYPE_VEHICLE_INQUIRY => 'Vehicle inquiry',
                        Lead::TYPE_CONTACT => 'Contact',
                        Lead::TYPE_FINANCE => 'Finance',
                        Lead::TYPE_TRADE_IN => 'Trade-in',
                        default => '-',
                    })
                    ->color(static fn(?string $state): string => match ($state) {
                        Lead::TYPE_VEHICLE_INQUIRY => 'info',
                        Lead::TYPE_CONTACT => 'gray',
                        Lead::TYPE_FINANCE => 'success',
                        Lead::TYPE_TRADE_IN => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(static fn(?string $state): string => match ($state) {
                        Lead::STATUS_NEW => 'New',
                        Lead::STATUS_CONTACTED => 'Contacted',
                        Lead::STATUS_QUALIFIED => 'Qualified',
                        Lead::STATUS_CLOSED => 'Closed',
                        Lead::STATUS_SPAM => 'Spam',
                        default => '-',
                    })
                    ->color(static fn(?string $state): string => match ($state) {
                        Lead::STATUS_NEW => 'info',
                        Lead::STATUS_CONTACTED => 'warning',
                        Lead::STATUS_QUALIFIED => 'success',
                        Lead::STATUS_CLOSED => 'gray',
                        Lead::STATUS_SPAM => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('source')
                    ->badge()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        Lead::TYPE_VEHICLE_INQUIRY => 'Vehicle inquiry',
                        Lead::TYPE_CONTACT => 'Contact',
                        Lead::TYPE_FINANCE => 'Finance',
                        Lead::TYPE_TRADE_IN => 'Trade-in',
                    ]),

                SelectFilter::make('status')
                    ->options([
                        Lead::STATUS_NEW => 'New',
                        Lead::STATUS_CONTACTED => 'Contacted',
                        Lead::STATUS_QUALIFIED => 'Qualified',
                        Lead::STATUS_CLOSED => 'Closed',
                        Lead::STATUS_SPAM => 'Spam',
                    ]),

                SelectFilter::make('source')
                    ->options([
                        'website' => 'Website',
                        'vehicle_page' => 'Vehicle page',
                        'contact_page' => 'Contact page',
                        'finance_page' => 'Finance page',
                        'trade_in_page' => 'Trade-in page',
                    ]),
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
