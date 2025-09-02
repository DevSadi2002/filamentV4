<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Form;
use Filament\Tables\Table;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'address';

    // protected static ?string $relatedResource = OrderResource::class;

    // form
    public function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->schema([
                TextInput::make('first_name')->required(),
                TextInput::make('last_name')->required(),
                TextInput::make('email')->required(),
                TextInput::make('phone')->required()->tel(),
                Textarea::make('street_address')->columnSpanFull()->required(),
                TextInput::make('city')->required(),
                TextInput::make('state')->required(),
                TextInput::make('zip_code')->required()->numeric(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                // Add columns for each fillable field
                // 'order_id' is usually a foreign key, you may want to show related order info instead
                // Text columns for address fields
                \Filament\Tables\Columns\TextColumn::make('first_name')->searchable(),
                \Filament\Tables\Columns\TextColumn::make('last_name')->searchable(),
                \Filament\Tables\Columns\TextColumn::make('email')->searchable(),
                \Filament\Tables\Columns\TextColumn::make('phone')->searchable(),
                \Filament\Tables\Columns\TextColumn::make('street_address')->limit(30),
                \Filament\Tables\Columns\TextColumn::make('city')->searchable(),
                \Filament\Tables\Columns\TextColumn::make('state')->searchable(),
                \Filament\Tables\Columns\TextColumn::make('zip_code'),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
            ])
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
