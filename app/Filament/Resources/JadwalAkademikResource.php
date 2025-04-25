<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JadwalAkademikResource\Pages;
use App\Filament\Resources\JadwalAkademikResource\RelationManagers;
use App\Models\JadwalAkademik;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JadwalAkademikResource extends Resource
{
    protected static ?string $model = JadwalAkademik::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kode_mk')
                    ->relationship('matakuliah', 'nama_mk')
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\Select::make('id_ruang')
                    ->relationship('ruang', 'nama_ruang')
                    ->required(),

                Forms\Components\Select::make('id_Gol')
                    ->relationship('golongan', 'nama_Gol')
                    ->required(),

                Forms\Components\Select::make('hari')
                    ->options([
                        'Senin' => 'Senin',
                        'Selasa' => 'Selasa',
                        'Rabu' => 'Rabu',
                        'Kamis' => 'Kamis',
                        'Jumat' => 'Jumat',
                        'Sabtu' => 'Sabtu'
                    ])
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('matakuliah.Nama_mk')
                    ->searchable(),

                Tables\Columns\TextColumn::make('ruang.nama_ruang'),

                Tables\Columns\TextColumn::make('golongan.nama_Gol'),

                Tables\Columns\TextColumn::make('hari')
            ])
            ->filters([
                //
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
            'index' => Pages\ListJadwalAkademiks::route('/'),
            'create' => Pages\CreateJadwalAkademik::route('/create'),
            'edit' => Pages\EditJadwalAkademik::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->isDefault() || auth()->user()->isAdmin() || auth()->user()->isDosen();
    }
}
