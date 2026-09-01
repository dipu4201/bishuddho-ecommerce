<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'বিক্রয়';
    protected static ?string $navigationLabel = 'কুপন';
    protected static ?string $modelLabel = 'কুপন';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('code')
                ->label('কুপন কোড')
                ->required()
                ->unique(ignoreRecord: true)
                ->alphaDash(),
            Forms\Components\Select::make('type')
                ->label('ধরন')
                ->options(['percentage' => 'শতাংশ (%)', 'fixed' => 'নির্দিষ্ট পরিমাণ (৳)'])
                ->required(),
            Forms\Components\TextInput::make('value')->label('মান')->numeric()->required(),
            Forms\Components\TextInput::make('min_order_amount')->label('সর্বনিম্ন অর্ডার মূল্য')->numeric(),
            Forms\Components\TextInput::make('max_discount_amount')->label('সর্বোচ্চ ছাড়ের পরিমাণ')->numeric(),
            Forms\Components\DateTimePicker::make('starts_at')->label('শুরুর তারিখ'),
            Forms\Components\DateTimePicker::make('expires_at')->label('মেয়াদ শেষ'),
            Forms\Components\TextInput::make('usage_limit')->label('সর্বমোট ব্যবহারের সীমা')->numeric(),
            Forms\Components\TextInput::make('per_user_limit')->label('প্রতি ইউজার ব্যবহারের সীমা')->numeric(),
            Forms\Components\Toggle::make('is_active')->label('সক্রিয়')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')->label('কোড')->searchable(),
                Tables\Columns\TextColumn::make('type')->label('ধরন'),
                Tables\Columns\TextColumn::make('value')->label('মান'),
                Tables\Columns\TextColumn::make('used_count')->label('ব্যবহৃত'),
                Tables\Columns\TextColumn::make('expires_at')->label('মেয়াদ শেষ')->dateTime('d M Y'),
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
