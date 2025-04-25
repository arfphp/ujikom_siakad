<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserAccountsResource\Pages;
use App\Filament\Resources\UserAccountsResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserAccountsResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Akun')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true),
                            
                        Forms\Components\Select::make('role')
                            ->options(User::ROLES)
                            ->required()
                            ->native(false),
                            
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->confirmed()
                            ->dehydrated(fn ($state) => filled($state))
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->visible(fn (string $operation): bool => $operation === 'create'),
                            
                        Forms\Components\TextInput::make('password_confirmation')
                            ->password()
                            ->revealable()
                            ->visible(fn (string $operation): bool => $operation === 'create')
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'dosen' => 'warning',
                        'mahasiswa' => 'success'
                    }),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options(User::ROLES)
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->visible(fn (User $record): bool => $record->role !== 'admin'),
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
            'index' => Pages\ListUserAccounts::route('/'),
            // 'create' => Pages\CreateUserAccounts::route('/create'),
            // 'edit' => Pages\EditUserAccounts::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->isAdmin();
    }
    public static function canCreate(): bool
{
    return false;
}

public static function canEdit($record): bool
{
    return false;
}

}
