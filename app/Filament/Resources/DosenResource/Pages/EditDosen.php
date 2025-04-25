<?php

namespace App\Filament\Resources\DosenResource\Pages;

use App\Filament\Resources\DosenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditDosen extends EditRecord
{
    protected static string $resource = DosenResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $dosen = $this->record;
        $user = $dosen->user;
        
        // Update user email
        if(isset($data['email'])) {
            $user->email = $data['email'];
            $user->save();
        }
        
        // Update password if provided
        if(!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
            $user->save();
        }
        
        unset($data['email'], $data['password'], $data['password_confirmation']);
        
        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl();
    }
}
