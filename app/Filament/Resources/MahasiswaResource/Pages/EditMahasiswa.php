<?php

namespace App\Filament\Resources\MahasiswaResource\Pages;

use App\Filament\Resources\MahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditMahasiswa extends EditRecord
{
    protected static string $resource = MahasiswaResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $mahasiswa = $this->record;
        $user = $mahasiswa->user;

        // Update email jika diubah
        if(isset($data['email']) && $data['email'] !== $user->email) {
            $user->email = $data['email'];
            $user->save();
        }

        // Update password jika diisi
        if(!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
            $user->save();
        }

        // Hapus field yang tidak diperlukan
        unset($data['email'], $data['password'], $data['password_confirmation']);

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function ($action) {
                    // Hapus user terkait saat hapus mahasiswa
                    $this->record->user()->delete();
                }),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl();
    }
}
