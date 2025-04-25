<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KrsResource\Pages;
use App\Filament\Resources\KrsResource\RelationManagers;
use App\Models\Krs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KrsResource extends Resource
{
    protected static ?string $model = Krs::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('NIM')
                    ->relationship('mahasiswa', 'Nama')
                    ->required()
                    ->visible(auth()->user()->isAdmin()),
                    
                Forms\Components\Select::make('Kode_mk')
                    ->relationship('matakuliah', 'Nama_mk')
                    ->required()
                    ->searchable()
                    ->preload()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mahasiswa.Nama')
                    ->visible(auth()->user()->isAdmin()),
                    
                Tables\Columns\TextColumn::make('matakuliah.Nama_mk'),
                
                Tables\Columns\TextColumn::make('matakuliah.sks'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('print')
                    ->label('Cetak')
                    ->url(fn (Krs $record) => route('krs.pdf', $record->NIM))
                    ->openUrlInNewTab()
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
            'index' => Pages\ListKrs::route('/'),
            'create' => Pages\CreateKrs::route('/create'),
            'edit' => Pages\EditKrs::route('/{record}/edit'),
        ];
    }
}
