<?php

namespace App\Filament\Resources\JadwalAkademikResource\Pages;

use App\Filament\Resources\JadwalAkademikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJadwalAkademik extends EditRecord
{
    protected static string $resource = JadwalAkademikResource::class;

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
