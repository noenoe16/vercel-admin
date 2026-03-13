<?php

namespace App\Filament\Resources\VoucherResource\Pages;

use App\Filament\Exports\VoucherExporter;
use App\Filament\Resources\VoucherResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageVouchers extends ManageRecords
{
    protected static string $resource = VoucherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ExportAction::make()
                ->exporter(VoucherExporter::class)
                ->label(__('Ekspor Data'))
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success'),
            Actions\CreateAction::make()
                ->label(__('Tambah Voucher'))
                ->icon('heroicon-o-plus')
                ->successNotification(
                    \Filament\Notifications\Notification::make()
                        ->success()
                        ->title(__('Voucher Ditambahkan'))
                        ->body(__('Voucher baru telah berhasil ditambahkan.'))
                ),
        ];
    }
}
