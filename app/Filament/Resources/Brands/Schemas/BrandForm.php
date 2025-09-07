<?php

namespace App\Filament\Resources\Brands\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(heading: [
                    'Category Information',
                    Grid::make([])->schema([
                        TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            // ->reactive()
                            ->lazy() // بدل reactive
                            ->afterStateUpdated(callback: fn(string $operation, $state, Set $set) => $operation === 'create'  ? $set('slug', Str::slug($state)) : null)
                            ->afterStateUpdated(callback: fn(string $operation, $state, Set $set) => $operation === 'edit'  ? $set('slug', Str::slug($state)) : null),

                        TextInput::make('slug')
                            ->disabled()
                            ->maxLength(255)
                            ->unique(table: 'brands', ignoreRecord: true)
                            ->dehydrated()
                            ->required(),

                        FileUpload::make('image')
                            ->image()
                            ->disk('public') // مهم!
                            ->directory('brands'),

                        Toggle::make('is_active')
                            ->default(true)
                            ->required(),
                    ])
                ])->columnSpanFull()
            ]);
    }
}
