<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Actions\ActionGroup;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';


    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')
                    ->label('Order ID')
                    ->searchable(),
                // status
                TextColumn::make('grand_total')
                    ->label('Grand Total')
                    ->money('usd', true)
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->label('Status')
                    ->color(fn($record) => match ($record->status) {
                        'new' => 'success',
                        'processing' => 'warning',
                        'shipped' => 'info',
                        'delivered' => 'primary',
                        'canceled' => 'danger',
                    })->icon(fn($record) => match ($record->status) {
                        'new' => 'heroicon-m-plus-circle',
                        'processing' => 'heroicon-m-cog',
                        'shipped' => 'heroicon-m-truck',
                        'delivered' => 'heroicon-m-check-circle',
                        'canceled' => 'heroicon-m-x-circle',
                    })
                    ->searchable(),
                TextColumn::make('payment_status')
                    ->sortable()
                    ->badge()
                    ->label('Payment Status')
                    ->searchable(),
                TextColumn::make('payment_method')
                    ->sortable()
                    ->badge()
                    ->label('Payment Method')
                    ->searchable(),
                // order date ...
                TextColumn::make('created_at')
                    ->label('Order Date')
                    ->date('M d, Y')
                    ->badge()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            // ->headerActions([
            //     CreateAction::make(),
            //     AssociateAction::make(),
            // ])
            ->recordActions([
                ViewAction::make('View Order')
                    ->url(fn(Order $record) => OrderResource::getUrl('view', ['record' => $record]))
                    ->openUrlInNewTab()
                    ->color('info'),
                ActionGroup::make([
                    EditAction::make(),
                    DissociateAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
