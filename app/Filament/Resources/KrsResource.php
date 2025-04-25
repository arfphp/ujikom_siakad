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
use App\Models\User;
class KrsResource extends Resource
{
    protected static ?string $model = Krs::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

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
            ...(auth()->user()->isAdmin() ? [Tables\Columns\TextColumn::make('mahasiswa.NIM')->label('NIM')] : []),
            Tables\Columns\TextColumn::make('matakuliah.Nama_mk')->label('Mata Kuliah')->searchable(),
            Tables\Columns\TextColumn::make('matakuliah.sks')->label('SKS'),
            Tables\Columns\TextColumn::make('matakuliah.semester')->label('Semester')->searchable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('semester')
                ->label('Filter Semester')
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
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['value'])) {
                        $query->whereHas('matakuliah', function($q) use ($data) {
                            $q->where('semester', $data['value']);
                        });
                    }
                })
        ])
        ->actions([
            Tables\Actions\Action::make('print')
                ->label('Cetak')
                ->form([
                    Forms\Components\Select::make('semester')
                        ->options(function () {

                            return [
                                1 => 'Semester 1',
                                2 => 'Semester 2',
                                3 => 'Semester 3',
                                4 => 'Semester 4',
                                5 => 'Semester 5',
                                6 => 'Semester 6',
                                7 => 'Semester 7',
                                8 => 'Semester 8',
                            ];
                        })
                        ->required()
                ])
                ->action(function (Krs $record, array $data) {
                    try {
                        return redirect()->route('krs.pdf', [
                            'nim' => $record->NIM,
                            'semester' => $data['semester']
                        ]);
                    } catch (\Exception $e) {
                        throw new \Exception("Gagal generate PDF: " . $e->getMessage());
                    }
                })
                ->icon('heroicon-o-printer')
            ])
            ->filters([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->visible(auth()->user()->isAdmin()),
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

    public static function canViewAny(): bool
    {
        return auth()->user()->isDefault() || auth()->user()->isAdmin();
    }
    public static function canCreate(): bool
    {
        return auth()->user()->isAdmin();
    }
    public static function canEditAny($record): bool
    {
        return auth()->user()->isAdmin();
    }
    public static function canEdit($record): bool
    {
        return auth()->user()->isAdmin();
    }
    public static function canDelete($record): bool
    {
        return auth()->user()->isAdmin($record);
    }
    public static function canForceDelete($record): bool
    {
        return auth()->user()->isAdmin();
    }
}
