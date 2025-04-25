<?php

namespace App\Filament\Resources\PresensiAkademikResource\Pages;

use App\Filament\Resources\PresensiAkademikResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePresensiAkademik extends CreateRecord
{
    protected static string $resource = PresensiAkademikResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl();
    }
}
