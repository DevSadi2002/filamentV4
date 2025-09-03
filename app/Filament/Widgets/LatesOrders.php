<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order as ModelsOrder;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatesOrders extends TableWidget
{
    protected static ?string $heading = 'Latest Orders';
    protected int | String | array $columnSpan = 'full';
    // sort 2
    protected static ?int $sort = 2;
    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label('Order ID')
                    ->searchable(),
                // status
                // user.name
                TextColumn::make('user.name')
                    ->label('Customer Name')
                    ->searchable(),
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
            ->headerActions([
                //
            ])
            ->recordActions([
                ViewAction::make('View Order')
                    ->url(fn(ModelsOrder $record) => OrderResource::getUrl('view', ['record' => $record]))
                    ->openUrlInNewTab()
                    ->color('info'),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
