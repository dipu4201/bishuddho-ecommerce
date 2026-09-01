<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class VariantsRelationManager extends RelationManager
{
    protected static string $relationship = 'variants';
    protected static ?string $title = 'ওজন / ভ্যারিয়েন্ট ও স্টক';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('label')
                ->label('লেবেল (যেমন: 1kg, 500g)')
                ->required(),
            Forms\Components\TextInput::make('sku')
                ->label('SKU')
                ->helperText('খালি রাখলে অটো জেনারেট হবে'),
            Forms\Components\TextInput::make('regular_price')
                ->label('নিয়মিত মূল্য (৳)')
                ->numeric()
                ->required(),
            Forms\Components\TextInput::make('sale_price')
                ->label('বিক্রয় মূল্য (৳)')
                ->numeric()
                ->helperText('ছাড় থাকলে দিন, নাহলে খালি রাখুন'),
            Forms\Components\TextInput::make('weight_value')
                ->label('ওজন')
                ->numeric(),
            Forms\Components\Select::make('weight_unit')
                ->label('একক')
                ->options(['g' => 'গ্রাম', 'kg' => 'কেজি', 'pcs' => 'পিস']),
            Forms\Components\TextInput::make('stock_quantity')
                ->label('স্টক পরিমাণ')
                ->numeric()
                ->default(0)
                ->required(),
            Forms\Components\TextInput::make('low_stock_threshold')
                ->label('লো-স্টক এলার্ট সীমা')
                ->numeric()
                ->default(5),
            Forms\Components\Toggle::make('is_default')->label('ডিফল্ট ভ্যারিয়েন্ট'),
            Forms\Components\Toggle::make('is_active')->label('সক্রিয়')->default(true),
        ])->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('label')
            ->columns([
                Tables\Columns\TextColumn::make('label')->label('লেবেল'),
                Tables\Columns\TextColumn::make('regular_price')->label('নিয়মিত মূল্য')->money('BDT'),
                Tables\Columns\TextColumn::make('sale_price')->label('বিক্রয় মূল্য')->money('BDT'),
                Tables\Columns\TextColumn::make('stock_quantity')->label('স্টক')->sortable(),
                Tables\Columns\TextColumn::make('reserved_quantity')->label('রিজার্ভড'),
                Tables\Columns\IconColumn::make('is_default')->boolean()->label('ডিফল্ট'),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('সক্রিয়'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
