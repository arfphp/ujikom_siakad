<?php

namespace App\Filament\Resources\UserAccountsResource\Pages;

use App\Filament\Resources\UserAccountsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserAccounts extends ListRecords
{
    protected static string $resource = UserAccountsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
