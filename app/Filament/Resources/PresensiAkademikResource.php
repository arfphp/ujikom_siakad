<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PresensiAkademikResource\Pages;
use App\Filament\Resources\PresensiAkademikResource\RelationManagers;
use App\Models\PresensiAkademi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;

class PresensiAkademikResource extends Resource
{
    protected static ?string $model = PresensiAkademi::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('Kode_mk')
                    ->relationship('matakuliah', 'Nama_mk')
                    ->required(),

                Forms\Components\Select::make('NIM')
                    ->relationship('mahasiswa', 'Nama')
                    ->required(),

                Forms\Components\DatePicker::make('tanggal')
                    ->required(),

                Forms\Components\Select::make('status_kehadiran')
                    ->options([
                        'Hadir' => 'Hadir',
                        'Izin' => 'Tidak Hadir',
                        'Sakit' => 'Sakit',
                        'Alpha' => 'Alpha'
                    ])
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('matakuliah.Nama_mk')->searchable(),

                Tables\Columns\TextColumn::make('mahasiswa.Nama')->searchable(),

                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->searchable(),

                Tables\Columns\TextColumn::make('status_kehadiran')->searchable()->color(fn (string $state): string => match ($state) {
                    'Alpha' => 'danger',
                    'Sakit' => 'danger',
                    'Izin' => 'warning',
                    'Hadir' => 'success'
                })
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->visible(fn (User $record): bool => 
                    auth()->user()->isAdmin()
                ),
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
            'index' => Pages\ListPresensiAkademiks::route('/'),
            'create' => Pages\CreatePresensiAkademik::route('/create'),
            'edit' => Pages\EditPresensiAkademik::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->isDefault();
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->isAdmin();
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->isAdmin();
    }

    public static function canForceDelete(Model $record): bool
    {
        return auth()->user()->isAdmin();
    }
}
