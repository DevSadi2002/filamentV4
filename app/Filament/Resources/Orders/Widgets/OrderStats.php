<?php

namespace App\Filament\Resources\Orders\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class OrderStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Orders', Order::query()->where('status', 'new')->count()),
            Stat::make('Processing Orders', Order::query()->where('status', 'processing')->count()),
            Stat::make('Shipped Orders', Order::query()->where('status', 'shipped')->count()),
            // average price
            Stat::make('Average Price', Number::currency(Order::query()->avg('grand_total')))
            // Stat::make('Delivered Orders', Order::query()->where('status', 'deliverd')->count()),
            // Stat::make('Canceled Orders', Order::query()->where('status', 'canceled')->count()),
        ];
    }
}
