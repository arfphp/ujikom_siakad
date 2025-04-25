<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as BaseRegister;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;

class Register extends BaseRegister
{
    protected function getForms(): array
{
    return [
        'form' => $this->form(
            $this->makeForm()
                ->schema([
                    TextInput::make('name')
                        ->label('Nama Lengkap')
                        ->required(),
                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->unique(),
                    TextInput::make('password')
                        ->password()
                        ->required()
                        ->confirmed(),
                    TextInput::make('password_confirmation')
                        ->password()
                        ->required(),
                    Select::make('role')
                        ->label('Role')
                        ->options([
                            'mahasiswa' => 'Mahasiswa',
                            'dosen' => 'Dosen',
                        ])
                        ->required()
                ])
                ->statePath('data'),
        ),
    ];
}

//     protected function create(array $data): \Illuminate\Database\Eloquent\Model
// {
//     $formData = $data['data']; // Ambil data dari key 'data'

//     $user = parent::create($formData);

//     try {
//         if ($formData['role'] === 'mahasiswa') {
//             Mahasiswa::create([
//                 'user_id' => $user->id,
//                 'NIM' => $formData['NIM'],
//                 'Nama' => $formData['name'],
//                 'Alamat' => $formData['Alamat'],
//                 'Nohp' => $formData['Nohp']
//             ]);
//         } elseif ($formData['role'] === 'dosen') {
//             Dosen::create([
//                 'user_id' => $user->id,
//                 'NIP' => $formData['NIP'],
//                 'Nama' => $formData['name'],
//                 'Alamat' => $formData['Alamat'],
//                 'Nohp' => $formData['Nohp']
//             ]);
//         }
//     } catch (\Exception $e) {
//         dd($e->getMessage());
//     }

//     auth()->logout();
//     return $user;
// }

protected function getRedirectUrl(): string
{
    return route('filament.admin.auth.login');
}

protected function afterRegistration(): void
{
    // Kosongkan untuk mencegah auto-login
}
}
