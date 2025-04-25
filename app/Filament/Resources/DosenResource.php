<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DosenResource\Pages;
use App\Filament\Resources\DosenResource\RelationManagers;
use App\Models\Dosen;
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

class DosenResource extends Resource
{
    protected static ?string $model = Dosen::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

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
            
            Forms\Components\Section::make('Data Dosen')
                ->schema([
                    Forms\Components\TextInput::make('NIP')
                        ->required()
                        ->regex('/^\d{18}$/'),
                        
                    Forms\Components\TextInput::make('Nama')
                        ->required(),
                        
                    Forms\Components\TextInput::make('Alamat')
                        ->required(),
                        
                    Forms\Components\TextInput::make('Nohp')
                        ->required()
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('NIP')->searchable(),
                TextColumn::make('Nama') ->searchable(),
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
            'index' => Pages\ListDosens::route('/'),
            'create' => Pages\CreateDosen::route('/create'),
            'edit' => Pages\EditDosen::route('/{record}/edit'),
        ];
    }
    public static function canViewAny(): bool
    {
        return auth()->user()->isDosen() || auth()->user()->isAdmin();
    }
}
