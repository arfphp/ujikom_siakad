<?php

namespace App\Filament\Resources\PresensiAkademikResource\Pages;

use App\Filament\Resources\PresensiAkademikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPresensiAkademik extends EditRecord
{
    protected static string $resource = PresensiAkademikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl();
    }
}
