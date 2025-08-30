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
                            ->reactive()
                            ->afterStateUpdated(callback: fn(string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                        TextInput::make('slug')
                            ->disabled()
                            ->maxLength(255)
                            ->unique(table: 'categories', ignoreRecord: true)
                            ->dehydrated()
                            ->required(),
                        FileUpload::make('image')
                            ->image()
                            ->directory('categories'),

                        Toggle::make('is_active')
                            ->default(true)
                            ->required(),
                    ])->columns(['sm' => 1, 'md' => 2, 'lg' => 2]),

                ])
            ]);
    }
}
