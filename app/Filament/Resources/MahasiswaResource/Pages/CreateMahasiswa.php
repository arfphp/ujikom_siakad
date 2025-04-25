<?php

namespace App\Filament\Resources\MahasiswaResource\Pages;

use App\Filament\Resources\MahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class CreateMahasiswa extends CreateRecord
{
    protected static string $resource = MahasiswaResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Create user
        $user = User::create([
            'name' => $data['Nama'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => User::ROLE_MAHASISWA
        ]);

        // Add user_id to mahasiswa data
        $data['user_id'] = $user->id;
        
        // Remove credentials from mahasiswa data
        unset($data['email'], $data['password'], $data['password_confirmation']);

        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl();
    }
}
