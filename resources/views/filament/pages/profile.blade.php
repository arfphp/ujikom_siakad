<x-filament::page>
    <form wire:submit.prevent="save">
        {{ $this->form }}

        <div class="flex justify-end mt-6">
            <x-filament::button type="submit">
                Simpan Profil
            </x-filament::button>
        </div>
    </form>

    @if (session('success'))
        <div class="p-4 mb-4 text-green-800 bg-green-50 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="p-4 mb-4 text-red-800 bg-red-50 rounded-lg">
            {{ session('error') }}
        </div>
    @endif
</x-filament::page>
