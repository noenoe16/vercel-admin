<div>
    <x-filament::section
        aside
        icon="heroicon-o-device-phone-mobile"
        :heading="__('Pengaturan Aplikasi')"
        :description="__('Buka pengaturan aplikasi untuk memberikan izin (kamera, lokasi, dll) jika sebelumnya ditolak.')"
    >
        <div class="flex items-center justify-end gap-x-3">
             <x-filament::button
                wire:click="openSettings"
                color="primary"
                icon="heroicon-o-cog-6-tooth"
                size="sm"
            >
                {{ __('Buka Pengaturan HP') }}
            </x-filament::button>
        </div>
    </x-filament::section>
</div>
