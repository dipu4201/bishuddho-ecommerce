<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    
    // ন্যাভিগেশন গ্রুপটি সাময়িকভাবে স্ট্রিং হিসেবে ঠিক রাখতে বা টাইপ সমস্যা এড়াতে নিচের মতো রাখা হয়েছে
    //public static ?string $navigationGroup = 'ক্যাটালগ';
    
    protected static \UnitEnum|string|null $navigationGroup = 'ক্যাটালগ';

    protected static ?string $modelLabel = 'ক্যাটাগরি';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\Select::make('parent_id')
                    ->label('প্যারেন্ট ক্যাটাগরি')
                    ->relationship('parent', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('name')
                    ->label('নাম (English)')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                //Forms\Components\TextInput::name_bn ?? 
                                                    Forms\Components\TextInput::make('name_bn')
                    ->label('নাম (বাংলা)'),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('description')
                    ->label('বিবরণ')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->label('ছবি')
                    ->image()
                    ->directory('categories'),
                Forms\Components\TextInput::make('icon')
                    ->label('আইকন / ইমোজি'),
                Forms\Components\TextInput::make('sort_order')
                    ->label('ক্রম')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('সক্রিয়')
                    ->default(true),
            ])->columns(2),

            Forms\Components\Section::make('SEO')->schema([
                Forms\Components\TextInput::make('meta_title'),
                Forms\Components\TextInput::make('meta_description'),
            ])->collapsed(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label(''),
                Tables\Columns\TextColumn::make('name')->label('নাম')->searchable(),
                Tables\Columns\TextColumn::make('name_bn')->label('বাংলা নাম'),
                Tables\Columns\TextColumn::make('parent.name')->label('প্যারেন্ট'),
                Tables\Columns\TextColumn::make('products_count')->counts('products')->label('পণ্য সংখ্যা'),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('সক্রিয়'),
                Tables\Columns\TextColumn::make('sort_order')->label('ক্রম')->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('সক্রিয়'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
