<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'বিক্রয়';
    protected static ?string $navigationLabel = 'অর্ডার';
    protected static ?string $modelLabel = 'অর্ডার';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('কাস্টমার তথ্য')->schema([
                Forms\Components\TextInput::make('order_number')->label('অর্ডার নম্বর')->disabled(),
                Forms\Components\TextInput::make('customer_name')->label('নাম')->required(),
                Forms\Components\TextInput::make('customer_phone')->label('ফোন')->required(),
                Forms\Components\TextInput::make('customer_email')->label('ইমেইল'),
            ])->columns(2),

            Forms\Components\Section::make('স্ট্যাটাস ও পেমেন্ট')->schema([
                Forms\Components\Select::make('status')
                    ->label('অর্ডার স্ট্যাটাস')
                    ->options(collect(Order::STATUSES)->mapWithKeys(fn ($s) => [$s => static::statusLabel($s)]))
                    ->required(),
                Forms\Components\Select::make('payment_status')
                    ->label('পেমেন্ট স্ট্যাটাস')
                    ->options([
                        'pending' => 'পেন্ডিং',
                        'paid' => 'পরিশোধিত',
                        'failed' => 'ব্যর্থ',
                        'refunded' => 'ফেরত',
                    ])->required(),
                Forms\Components\Select::make('payment_method')
                    ->label('পেমেন্ট মাধ্যম')
                    ->options([
                        'cod' => 'ক্যাশ অন ডেলিভারি',
                        'bkash' => 'বিকাশ',
                        'nagad' => 'নগদ',
                        'rocket' => 'রকেট',
                        'card' => 'কার্ড',
                        'bank_transfer' => 'ব্যাংক ট্রান্সফার',
                    ])->required(),
                Forms\Components\TextInput::make('payment_transaction_id')->label('ট্রানজেকশন আইডি'),
            ])->columns(2),

            Forms\Components\Section::make('মূল্য')->schema([
                Forms\Components\TextInput::make('subtotal')->numeric()->required(),
                Forms\Components\TextInput::make('discount_amount')->numeric()->default(0),
                Forms\Components\TextInput::make('delivery_fee')->numeric()->default(0),
                Forms\Components\TextInput::make('total')->numeric()->required(),
            ])->columns(4),

            Forms\Components\Textarea::make('note')->label('নোট')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')->label('অর্ডার নম্বর')->searchable(),
                Tables\Columns\TextColumn::make('customer_name')->label('কাস্টমার')->searchable(),
                Tables\Columns\TextColumn::make('customer_phone')->label('ফোন'),
                Tables\Columns\TextColumn::make('total')->label('মোট')->money('BDT'),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('স্ট্যাটাস')
                    ->formatStateUsing(fn (string $state) => static::statusLabel($state))
                    ->colors([
                        'gray' => 'pending',
                        'info' => fn ($state) => in_array($state, ['confirmed', 'processing', 'packed']),
                        'warning' => fn ($state) => in_array($state, ['shipped', 'out_for_delivery']),
                        'success' => 'delivered',
                        'danger' => fn ($state) => in_array($state, ['cancelled', 'returned', 'refunded']),
                    ]),
                Tables\Columns\BadgeColumn::make('payment_status')
                    ->label('পেমেন্ট')
                    ->colors([
                        'gray' => 'pending',
                        'success' => 'paid',
                        'danger' => 'failed',
                        'warning' => 'refunded',
                    ]),
                Tables\Columns\TextColumn::make('created_at')->label('তারিখ')->dateTime('d M Y, h:i A')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(collect(Order::STATUSES)->mapWithKeys(fn ($s) => [$s => static::statusLabel($s)])),
                Tables\Filters\SelectFilter::make('payment_method')
                    ->options([
                        'cod' => 'COD', 'bkash' => 'বিকাশ', 'nagad' => 'নগদ',
                        'rocket' => 'রকেট', 'card' => 'কার্ড', 'bank_transfer' => 'ব্যাংক',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function statusLabel(string $status): string
    {
        return match ($status) {
            'pending' => 'পেন্ডিং',
            'confirmed' => 'কনফার্মড',
            'processing' => 'প্রসেসিং',
            'packed' => 'প্যাকড',
            'shipped' => 'শিপড',
            'out_for_delivery' => 'ডেলিভারির পথে',
            'delivered' => 'ডেলিভারড',
            'cancelled' => 'বাতিল',
            'returned' => 'ফেরত',
            'refunded' => 'রিফান্ডেড',
            default => $status,
        };
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
