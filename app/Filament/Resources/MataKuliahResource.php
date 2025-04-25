<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MataKuliahResource\Pages;
use App\Filament\Resources\MataKuliahResource\RelationManagers;
use App\Models\MataKuliah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MataKuliahResource extends Resource
{
    protected static ?string $model = MataKuliah::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    // protected static ?string $navigationGroup = 'Akademik';
    // protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Mata Kuliah')
                    ->schema([
                        Forms\Components\TextInput::make('Kode_mk')
                            ->label('Kode MK')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(10)
                            ->columnSpan(1),
                            
                        Forms\Components\TextInput::make('Nama_mk')
                            ->label('Nama Mata Kuliah')
                            ->required()
                            ->maxLength(150)
                            ->columnSpan(2),
                            
                        Forms\Components\TextInput::make('sks')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->maxValue(6)
                            ->default(3),
                            
                        Forms\Components\TextInput::make('semester')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->maxValue(8)
                    ])
                    ->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Kode_mk')
                    ->searchable()
                    ->sortable()
                    ->label('Kode MK'),
                    
                Tables\Columns\TextColumn::make('Nama_mk')
                    ->searchable()
                    ->sortable()
                    ->label('Mata Kuliah')
                    ->wrap(),
                    
                Tables\Columns\TextColumn::make('sks')
                    ->sortable()
                    ->label('SKS')
                    ->alignCenter(),
                    
                Tables\Columns\TextColumn::make('semester')
                    ->sortable()
                    ->label('Semester')
                    ->alignCenter()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('semester')
                    ->options([
                        1 => 'Semester 1',
                        2 => 'Semester 2',
                        3 => 'Semester 3',
                        4 => 'Semester 4',
                        5 => 'Semester 5',
                        6 => 'Semester 6',
                        7 => 'Semester 7',
                        8 => 'Semester 8',
                    ])
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMataKuliahs::route('/'),
            'create' => Pages\CreateMataKuliah::route('/create'),
            'edit' => Pages\EditMataKuliah::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->isAdmin() || auth()->user()->isDosen() || auth()->user()->isDefault();
    }
}
