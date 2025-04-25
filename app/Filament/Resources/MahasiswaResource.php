<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MahasiswaResource\Pages;
use App\Filament\Resources\MahasiswaResource\RelationManagers;
use App\Models\Mahasiswa;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
class MahasiswaResource extends Resource
{
    protected static ?string $model = Mahasiswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Section::make('Akun Pengguna')
                ->schema([
                    Forms\Components\TextInput::make('email')
                        ->required()
                        ->email()
                        ->unique(table: User::class)
                        ->label('Email Login'),
                        
                    Forms\Components\TextInput::make('password')
                        ->required()
                        ->password()
                        ->visibleOn('create')
                        ->confirmed(),
                        
                    Forms\Components\TextInput::make('password_confirmation')
                        ->required()
                        ->password()
                        ->visibleOn('create')
                ])
                ->columns(2),
            
            Forms\Components\Section::make('Data Mahasiswa')
                ->schema([
                    Forms\Components\TextInput::make('NIM')
                        ->required()
                        ->regex('/^[A-Z]\d{8}$/'),
                        
                    Forms\Components\TextInput::make('Nama')
                        ->required(),
                        
                    Forms\Components\TextInput::make('Alamat')
                        ->required(),
                        
                    Forms\Components\TextInput::make('Nohp')
                        ->required(),
                        
                    Forms\Components\Select::make('id_Gol')
                        ->relationship('golongan', 'nama_Gol')
                        ->required(),
                        
                    Forms\Components\Select::make('Semester')
                        ->options(array_combine(range(1,8), range(1,8)))
                        ->required()
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('NIM')->searchable(),
                TextColumn::make('Nama')->searchable(),
                TextColumn::make('Semester')->searchable(),
                TextColumn::make('user.email')->searchable()
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
            'index' => Pages\ListMahasiswas::route('/'),
            'create' => Pages\CreateMahasiswa::route('/create'),
            'edit' => Pages\EditMahasiswa::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->isAdmin();
    }
}
