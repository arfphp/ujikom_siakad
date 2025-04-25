<?php

namespace App\Filament\Resources\JadwalAkademikResource\Pages;

use App\Filament\Resources\JadwalAkademikResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJadwalAkademik extends CreateRecord
{
    protected static string $resource = JadwalAkademikResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl();
    }
}
