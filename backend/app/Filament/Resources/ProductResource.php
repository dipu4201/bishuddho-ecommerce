<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'ক্যাটালগ';
    protected static ?string $navigationLabel = 'পণ্য';
    protected static ?string $modelLabel = 'পণ্য';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make('মৌলিক তথ্য')->schema([
                    Forms\Components\Select::make('category_id')
                        ->label('ক্যাটাগরি')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\TextInput::make('name')
                        ->label('নাম (English)')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                    Forms\Components\TextInput::make('name_bn')
                        ->label('নাম (বাংলা)'),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true),
                    Forms\Components\TextInput::make('sku')
                        ->label('SKU')
                        ->unique(ignoreRecord: true)
                        ->helperText('খালি রাখলে অটো জেনারেট হবে'),
                    Forms\Components\Textarea::make('short_description')
                        ->label('সংক্ষিপ্ত বিবরণ')
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('description')
                        ->label('বিস্তারিত বিবরণ')
                        ->columnSpanFull(),
                ])->columns(2),

                Forms\Components\Section::make('অতিরিক্ত তথ্য')->schema([
                    Forms\Components\Textarea::make('ingredients')->label('উপাদান'),
                    Forms\Components\TextInput::make('origin')->label('উৎস'),
                    Forms\Components\Textarea::make('storage_instructions')->label('সংরক্ষণ নির্দেশনা'),
                ])->columns(2)->collapsed(),

                Forms\Components\Section::make('SEO')->schema([
                    Forms\Components\TextInput::make('meta_title'),
                    Forms\Components\TextInput::make('meta_description'),
                ])->collapsed(),
            ])->columnSpan(2),

            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make('প্রকাশনা')->schema([
                    Forms\Components\Select::make('status')
                        ->label('স্ট্যাটাস')
                        ->options([
                            'draft' => 'খসড়া',
                            'active' => 'সক্রিয়',
                            'inactive' => 'নিষ্ক্রিয়',
                        ])
                        ->default('draft')
                        ->required(),
                    Forms\Components\Toggle::make('is_featured')->label('ফিচার্ড পণ্য'),
                    Forms\Components\Toggle::make('is_seasonal')->label('সিজনাল পণ্য'),
                ]),
                Forms\Components\Section::make('থাম্বনেইল')->schema([
                    Forms\Components\FileUpload::make('thumbnail')
                        ->label('')
                        ->image()
                        ->directory('products'),
                ]),
            ])->columnSpan(1),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')->label(''),
                Tables\Columns\TextColumn::make('name')->label('নাম')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('category.name')->label('ক্যাটাগরি'),
                Tables\Columns\TextColumn::make('sku')->label('SKU')->toggleable(),
                Tables\Columns\TextColumn::make('variants_min_price')
                    ->label('শুরু মূল্য')
                    ->state(fn (Product $record) => $record->variants()->min('sale_price')
                        ?? $record->variants()->min('regular_price') ?? '—'),
                Tables\Columns\TextColumn::make('stock_total')
                    ->label('মোট স্টক')
                    ->state(fn (Product $record) => $record->variants()->sum('stock_quantity')),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('স্ট্যাটাস')
                    ->colors([
                        'gray' => 'draft',
                        'success' => 'active',
                        'danger' => 'inactive',
                    ]),
                Tables\Columns\IconColumn::make('is_featured')->boolean()->label('ফিচার্ড'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('ক্যাটাগরি')
                    ->relationship('category', 'name'),
                Tables\Filters\SelectFilter::make('status')
                    ->options(['draft' => 'খসড়া', 'active' => 'সক্রিয়', 'inactive' => 'নিষ্ক্রিয়']),
                Tables\Filters\TernaryFilter::make('is_featured')->label('ফিচার্ড'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\VariantsRelationManager::class,
            RelationManagers\ImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
