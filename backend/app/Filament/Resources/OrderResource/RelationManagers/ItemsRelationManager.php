<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';
    protected static ?string $title = 'অর্ডার আইটেম';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_name')
            ->columns([
                Tables\Columns\TextColumn::make('product_name')->label('পণ্য'),
                Tables\Columns\TextColumn::make('variant_label')->label('ভ্যারিয়েন্ট'),
                Tables\Columns\TextColumn::make('unit_price')->label('একক মূল্য')->money('BDT'),
                Tables\Columns\TextColumn::make('quantity')->label('পরিমাণ'),
                Tables\Columns\TextColumn::make('line_total')->label('মোট')->money('BDT'),
            ]);
    }
}
