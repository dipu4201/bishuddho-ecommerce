<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryZoneResource\Pages;
use App\Models\DeliveryZone;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DeliveryZoneResource extends Resource
{
    protected static ?string $model = DeliveryZone::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'সেটিংস';
    protected static ?string $navigationLabel = 'ডেলিভারি জোন';
    protected static ?string $modelLabel = 'ডেলিভারি জোন';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label('নাম (English)')->required(),
            Forms\Components\TextInput::make('name_bn')->label('নাম (বাংলা)'),
            Forms\Components\TextInput::make('fee')->label('ডেলিভারি চার্জ (৳)')->numeric()->required(),
            Forms\Components\TextInput::make('free_delivery_threshold')->label('ফ্রি ডেলিভারির সীমা (৳)')->numeric(),
            Forms\Components\TextInput::make('estimated_days_min')->label('সর্বনিম্ন দিন')->numeric()->default(1),
            Forms\Components\TextInput::make('estimated_days_max')->label('সর্বোচ্চ দিন')->numeric()->default(3),
            Forms\Components\Toggle::make('is_active')->label('সক্রিয়')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('নাম'),
                Tables\Columns\TextColumn::make('name_bn')->label('বাংলা নাম'),
                Tables\Columns\TextColumn::make('fee')->label('চার্জ')->money('BDT'),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('সক্রিয়'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeliveryZones::route('/'),
            'create' => Pages\CreateDeliveryZone::route('/create'),
            'edit' => Pages\EditDeliveryZone::route('/{record}/edit'),
        ];
    }
}
