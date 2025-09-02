<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\ActionGroup;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\DateFilter;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Actions\GroupBulkAction;
use Filament\Tables\Columns\SelectColumn;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('grand_total')
                    ->label('Grand Total')
                    ->numeric()
                    ->sortable()
                    ->money(fn($record) => $record->currency ?? 'USD')
                    ->toggleable(),
                TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('payment_status')
                    ->label('Payment Status')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('currency')
                    ->label('Currency')
                    ->searchable(),
                TextColumn::make('shipping_method')
                    ->label('Shipping Method')
                    ->searchable(),
                SelectColumn::make('status')
                    ->label('Order Status')
                    ->options([
                        'new' => 'New',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ])
                    ->toggleable(),

                TextColumn::make('shipping_amount')
                    ->label('Shipping Amount')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ]),
                SelectFilter::make('currency')
                    ->options([
                        'NIS' => 'NIS',
                        'USD' => 'USD',
                        'EUR' => 'EUR',
                        'GBP' => 'GBP',
                    ]),

            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),


                ]),
            ]);
    }
}
