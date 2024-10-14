<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Button;
use App\Filament\Resources\ProductResource\Pages;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3) // Membuat grid dengan 3 kolom
                    ->schema([
                        FileUpload::make('photo')
                            ->image()
                            ->directory('product-photos')
                            ->maxSize(1024)
                            ->nullable()
                            ->label('Upload Image')
                            ->columnSpan(1) // Gambar tetap di kolom pertama
                            ->extraAttributes(['style' => 'background-color: #f0f4f8;']), // Menambahkan custom height melalui CSS inline
                        
                        Grid::make() // Grid untuk form di sebelah kanan
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Product Name')
                                    ->columnSpan(2),
                                TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->placeholder('Input price')
                                    ->columnSpan(2),
                                Select::make('category_id')
                                    ->label('Select category')
                                    ->options(Category::all()->pluck('name', 'id'))
                                    ->required()
                                    ->searchable()
                                    ->placeholder('Select category')
                                    ->columnSpan(2),
                            ])
                            ->columnSpan(2) // Input berada di dua kolom di sebelah kanan
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('idr')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('photo'),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->relationship('category', 'name')
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

    public static function getRelations(): array
    {
        return [
            //
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
