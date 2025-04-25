<?php
namespace App\Filament\Resources\MataKuliahResource\Relations;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PengampuRelationManager extends RelationManager
{
    protected static string $relationship = 'pengampu';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('NIP')
                    ->relationship('dosen', 'Nama')
                    ->required()
                    ->searchable()
                    ->preload()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('dosen.Nama')
                    ->label('Dosen'),
                    
                Tables\Columns\TextColumn::make('dosen.NIP')
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}