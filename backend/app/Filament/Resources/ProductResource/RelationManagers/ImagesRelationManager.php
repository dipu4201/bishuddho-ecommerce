<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';
    protected static ?string $title = 'গ্যালারি ছবি';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\FileUpload::make('path')
                ->label('ছবি')
                ->image()
                ->directory('products/gallery')
                ->required(),
            Forms\Components\TextInput::make('alt_text')->label('Alt টেক্সট'),
            Forms\Components\TextInput::make('sort_order')->label('ক্রম')->numeric()->default(0),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('alt_text')
            ->columns([
                Tables\Columns\ImageColumn::make('path')->label('ছবি'),
                Tables\Columns\TextColumn::make('alt_text')->label('Alt টেক্সট'),
                Tables\Columns\TextColumn::make('sort_order')->label('ক্রম'),
            ])
            ->defaultSort('sort_order')
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
