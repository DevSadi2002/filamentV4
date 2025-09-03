<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Filament\Resources\Orders\Widgets\OrderStats;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),

        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            OrderStats::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'null' => Tab::make('All'),
            'new' => Tab::make('New')->query(fn($query) => $query->where('status', 'new')),
            'processing' => Tab::make('Processing')->query(fn($query) => $query->where('status', 'processing')),
            'shipped' => Tab::make('Shipped')->query(fn($query) => $query->where('status', 'shipped')),
            'deliverd' => Tab::make('Deliverd')->query(fn($query) => $query->where('status', 'deliverd')),
            'canceled' => Tab::make('Canceled')->query(fn($query) => $query->where('status', 'canceled'))
        ];
    }
}
