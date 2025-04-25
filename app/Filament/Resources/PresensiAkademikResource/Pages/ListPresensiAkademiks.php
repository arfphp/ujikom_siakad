<?php

namespace App\Filament\Resources\PresensiAkademikResource\Pages;

use App\Filament\Resources\PresensiAkademikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPresensiAkademiks extends ListRecords
{
    protected static string $resource = PresensiAkademikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
