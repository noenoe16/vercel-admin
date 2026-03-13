<?php

namespace App\Filament\Resources\PackageResource\Pages;

use App\Filament\Exports\PackageExporter;
use App\Filament\Resources\PackageResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePackages extends ManageRecords
{
    protected static string $resource = PackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ExportAction::make()
                ->exporter(PackageExporter::class)
                ->label(__('Ekspor Data'))
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success'),
            Actions\CreateAction::make()
                ->label(__('Tambah Paket'))
                ->icon('heroicon-o-plus')
                ->successNotification(
                    \Filament\Notifications\Notification::make()
                        ->success()
                        ->title(__('Paket Ditambahkan'))
                        ->body(__('Paket baru telah berhasil ditambahkan.'))
                ),
        ];
    }
}
