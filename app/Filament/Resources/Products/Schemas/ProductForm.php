<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()->schema([
                    Section::make('Product Information')->schema([
                        TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(callback: fn(string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->required()
                            ->disabled()
                            ->maxLength(255)
                            ->unique(Product::class, ignoreRecord: true)
                            ->helperText('If left empty, the slug will be generated from the name.')
                            ->dehydrated(),
                        MarkdownEditor::make('description')
                            ->columnSpanFull()
                            ->fileAttachmentsDirectory('products/descriptions')
                    ])->columns(2),
                    Section::make('Product Details')->schema([
                        FileUpload::make('image')
                            ->image()
                            ->multiple()
                            ->maxFiles(5)
                            ->directory('products/images')
                            ->reorderable(),
                    ]),

                ])->columnSpan(2),
                Group::make()->schema([
                    Section::make('Pricing & Stock')->schema([
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->minValue(0)
                            ->step(0.01),
                    ]),
                    Section::make('Associations')->schema([
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->preload()
                            ->searchable()
                            ->required(),
                        Select::make('brand_id')
                            ->relationship('brand', 'name')
                            ->preload()
                            ->searchable()
                            ->required(),
                    ]),
                    Section::make('Status')->schema([
                        Toggle::make('in_stock')
                            ->required()
                            ->label('Active')
                            ->default(true),
                        Toggle::make('is_active')
                            ->required()
                            ->default(true),
                        Toggle::make('is_featured')
                            ->required()

                            ->label('Featured')
                            ->default(false),
                        Toggle::make('on_sale')
                            ->label('On Sale')
                            ->required()

                            ->default(false),


                    ])
                ])->columnSpan(1),
            ])->columns(3);
    }
}
