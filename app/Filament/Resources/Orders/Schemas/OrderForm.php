<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Product;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Number;

use function Laravel\Prompts\select;
use function Laravel\Prompts\textarea;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()->schema([
                    Section::make('Order Details')
                        ->columns(2)
                        ->schema([
                            select::make('user_id')
                                ->label('Customer')
                                ->reactive()
                                ->relationship('user', 'name')
                                ->searchable()
                                ->preload(),

                            select::make('payment_method')
                                ->options([
                                    'stripe' => 'Stripe',
                                    'cod' => 'Cash on Delivery',
                                ])
                                ->required(),

                            select::make('payment_status')
                                ->options([
                                    'pending' => 'Pending',
                                    'paid' => 'Paid',
                                    'failed' => 'Failed',
                                ])
                                ->default('pending')
                                ->required(),

                            ToggleButtons::make('status')
                                ->inline()
                                ->options([
                                    'new' => 'New',
                                    'processing' => 'Processing',
                                    'shipped' => 'Shipped',
                                    'delivered' => 'Delivered',
                                    'cancelled' => 'Cancelled',
                                ])
                                ->default('new')
                                ->colors([
                                    'new' => 'info',
                                    'processing' => 'warning',
                                    'shipped' => 'info',
                                    'delivered' => 'success',
                                    'cancelled' => 'danger',
                                ])
                                ->icons([
                                    'new' => 'heroicon-o-sparkles',
                                    'processing' => 'heroicon-o-arrow-path',
                                    'shipped' => 'heroicon-o-truck',
                                    'delivered' => 'heroicon-o-check-circle',
                                    'cancelled' => 'heroicon-o-x-circle',
                                ])
                                ->required(),

                            select::make('currency')
                                ->options([
                                    'NIS' => 'NIS', // Israeli New Shekel
                                    'USD' => 'USD',
                                    'EUR' => 'EUR',
                                    'GBP' => 'GBP',
                                ])
                                ->default('USD')
                                ->required(),

                            select::make('shipping_method')
                                ->options([
                                    'fedex' => 'FedEx',
                                    'ups' => 'UPS',
                                    'dhl' => 'DHL',
                                    'usps' => 'USPS',
                                ])
                                ->required(),

                            textarea::make('notes')->columnSpanFull(),
                        ]),
                    Section::make('Order Items')
                        ->schema([
                            Repeater::make('items')
                                ->relationship('items')
                                ->columns(4)
                                ->defaultItems(1)
                                ->createItemButtonLabel('Add Item')
                                ->columnSpanFull()
                                ->schema([
                                    select::make('product_id')
                                        ->label('Product')
                                        ->reactive()
                                        ->relationship('product', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->distinct()
                                        ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                        ->afterStateUpdated(function ($state, Set $set) {
                                            $product = Product::find($state);
                                            $price = $product?->price ?? 0;
                                            $set('unit_amount', $price);
                                            $set('total_amount', $price);
                                        })
                                        ->required(),

                                    TextInput::make('quantity')
                                        ->reactive()
                                        ->numeric()
                                        ->minValue(1)
                                        ->default(1)
                                        ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                            $set('total_amount', $state * $get('unit_amount'));
                                        })
                                        ->required(),

                                    TextInput::make('unit_amount')
                                        ->numeric()
                                        ->dehydrated()
                                        ->disabled()
                                        ->required(),

                                    TextInput::make('total_amount')
                                        ->numeric()
                                        ->dehydrated()
                                        ->disabled()
                                        ->required(),
                                ]),
                        ]),
                    Placeholder::make('grand_total_placeholder')
                        ->label('Grand Total')
                        ->content(function (Get $get): string {
                            $total = 0;
                            $items = $get('items') ?? [];
                            foreach ($items as $key => $item) {
                                $total += $item['total_amount'] ?? 0;
                            }
                            return Number::currency($total, in: $get('currency') ?? 'USD');
                        }),
                    Hidden::make('grand_total')
                        ->default(0),
                ])->columnSpanFull(),
            ]);
    }
}
