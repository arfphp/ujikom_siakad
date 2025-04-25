<?php

namespace App\Filament\Resources\DosenResource\Pages;

use App\Filament\Resources\DosenResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class CreateDosen extends CreateRecord
{
    protected static string $resource = DosenResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Create user
        $user = User::create([
            'name' => $data['Nama'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => User::ROLE_DOSEN
        ]);

        // Add user_id to dosen data
        $data['user_id'] = $user->id;
        
        // Remove credentials from dosen data
        unset($data['email'], $data['password'], $data['password_confirmation']);

        return $data;
    }
     protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl();
    }
}
