<?php

namespace App\Filament\Resources\UserAccountsResource\Pages;

use App\Filament\Resources\UserAccountsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserAccounts extends EditRecord
{
    protected static string $resource = UserAccountsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
