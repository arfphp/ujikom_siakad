<?php

namespace App\Filament\Resources\JadwalAkademikResource\Pages;

use App\Filament\Resources\JadwalAkademikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJadwalAkademiks extends ListRecords
{
    protected static string $resource = JadwalAkademikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
