<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Golongan;
use Illuminate\Support\Facades\Auth;

class Profile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static string $view = 'filament.pages.profile';

    public $user;
    public array $data = [];

    public function mount(): void
{
    $this->user = Auth::user();

    // Inisialisasi data dengan nilai dari user
    $this->data = [
        'name' => $this->user->name,
        'email' => $this->user->email,
        'role' => $this->user->role
    ];

    // Load existing data jika sudah ada
    if($this->user->role === 'mahasiswa') {
        $mahasiswa = Mahasiswa::where('user_id', $this->user->id)->first();
        if($mahasiswa) {
            $this->data = array_merge($this->data, $mahasiswa->toArray());
        }
    } else {
        $dosen = Dosen::where('user_id', $this->user->id)->first();
        if($dosen) {
            $this->data = array_merge($this->data, $dosen->toArray());
        }
    }

    $this->form->fill($this->data);
}

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->default($this->user->name)
                    ->disabled()
                    ->dehydrated(),
                TextInput::make('email')
                    ->label('Email')
                    ->default($this->user->email)
                    ->disabled(),

                $this->user->role === 'mahasiswa' ?
                TextInput::make('NIM')
                    ->label('NIM')
                    ->required()
                    ->regex('/^[A-Z]\d{8}$/')
                    ->validationMessages([
                        'regex' => 'Format NIM tidak valid. Contoh: E41210766'
                ])
                 :
                TextInput::make('NIP')
                    ->label('NIP')
                    ->required()
                    ->regex('/^\d{18}$/')
                    ->validationMessages([
                        'regex' => 'Format NIP harus 18 digit angka'
                    ]),

                $this->user->role === 'mahasiswa' ?
                Select::make('id_Gol')
                    ->label('Golongan')
                    ->options(Golongan::all()->pluck('nama_Gol', 'id_Gol'))
                 :
                Select::make('ini hidden')
                    ->label('ini hidden')
                    ->options([
                         '1' => '1',
                    ])
                    ->hidden($this->user->role === 'dosen'),
                $this->user->role === 'mahasiswa' ?
                Select::make('Semester')
                    ->label('Semester')
                    ->options([
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                        '7' => '7',
                        '8' => '8',
                    ])
                 :
                 Select::make('ini hidden')
                    ->label('ini hidden')
                    ->options([
                        '1' => '1',
                    ])
                 ->hidden($this->user->role === 'dosen'),
                TextInput::make('Alamat')
                    ->required(),

                TextInput::make('Nohp')
                    ->tel()
                    ->required(),

                TextInput::make('role')
                    ->label('Role')
                    ->default($this->user->role)
                    ->disabled()
                    ->dehydrated()
            ])
            ->statePath('data'); // Penting: binding data ke array
    }

    public function save()
    {
        $data = $this->form->getState();

        try {
            if($this->user->role === 'mahasiswa') {
                Mahasiswa::updateOrCreate(
                    ['user_id' => $this->user->id],
                    [
                        'NIM' => $data['NIM'],
                        'Nama' => $this->user->name,
                        'Alamat' => $data['Alamat'],
                        'Semester' => $data['Semester'],
                        'id_Gol' => $data['id_Gol'],
                        'Nohp' => $data['Nohp']
                    ]
                );
            } else {
                Dosen::updateOrCreate(
                    ['user_id' => $this->user->id],
                    [
                        'NIP' => $data['NIP'],
                        'Nama' => $this->user->name,
                        'Alamat' => $data['Alamat'],
                        'Nohp' => $data['Nohp']
                    ]
                );
            }

            return redirect()->route('filament.admin.pages.dashboard')
        ->with('success', 'Profil berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }
    public static function canViewAny(): bool
    {
        return auth()->user()->isDefault() || auth()->user()->isDosen();
    }
}
