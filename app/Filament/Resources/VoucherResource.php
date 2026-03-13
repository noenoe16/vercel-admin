<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VoucherResource\Pages;
use App\Models\Voucher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VoucherResource extends Resource
{
    protected static ?string $model = Voucher::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'code';

    
    
    public static function getNavigationGroup(): ?string
    {
        return __('Transaksi');
    }

    public static function getNavigationLabel(): string
    {
        return __('Voucher Promo');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::$model::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return __('Total Voucher Promo');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['code', 'description'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Detail Voucher'))
                    ->description(__('Informasi umum tentang voucher.'))
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label(__('Kode Voucher'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('description')
                            ->label(__('Deskripsi'))
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make(__('Konfigurasi Diskon'))
                    ->description(__('Pengaturan nilai diskon.'))
                    ->schema([
                        Forms\Components\TextInput::make('discount_amount')
                            ->label(__('Jumlah Diskon'))
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                        Forms\Components\ToggleButtons::make('discount_type')
                            ->label(__('Tipe Diskon'))
                            ->options([
                                'fixed' => __('Jumlah Tetap (Rp)'),
                                'percentage' => __('Persentase (%)'),
                            ])
                            ->icons([
                                'fixed' => 'heroicon-m-currency-dollar',
                                'percentage' => 'heroicon-m-percent-badge',
                            ])
                            ->colors([
                                'fixed' => 'info',
                                'percentage' => 'success',
                            ])
                            ->default('fixed')
                            ->required()
                            ->inline()
                            ->reactive(),
                        Forms\Components\TextInput::make('min_purchase')
                            ->label(__('Pembelian Minimum'))
                            ->numeric()
                            ->prefix('Rp'),
                    ])->columns(3),

                Forms\Components\Section::make(__('Pengaturan Ketersediaan'))
                    ->description(__('Kelola waktu berlaku voucher dan statusnya.'))
                    ->schema([
                        Forms\Components\DateTimePicker::make('expires_at')
                            ->label(__('Tanggal Kadaluarsa')),
                        Forms\Components\Toggle::make('is_active')
                            ->label(__('Status Aktif'))
                            ->default(true)
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label(__('Kode'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_amount')
                    ->label(__('Diskon'))
                    ->money('IDR')
                    ->sortable()
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('discount_type')
                    ->label(__('Tipe'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'fixed' => 'info',
                        'percentage' => 'success',
                    })
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('expires_at')
                    ->label(__('Kadaluarsa Pada'))
                    ->dateTime()
                    ->sortable()
                    ->alignment('center'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('Status'))
                    ->boolean()
                    ->searchable()
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Dibuat Pada'))
                    ->dateTime()
                    ->sortable()
                    ->alignment('center')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('Status Aktif')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->button()
                    ->color('info')
                    ->size('lg'),
                Tables\Actions\EditAction::make()
                    ->button()
                    ->color('warning')
                    ->size('lg')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title(__('Voucher diperbarui'))
                            ->body(__('Voucher telah berhasil diperbarui.'))
                    ),
                Tables\Actions\DeleteAction::make()
                    ->button()
                    ->color('danger')
                    ->size('lg')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title(__('Voucher dihapus'))
                            ->body(__('Voucher telah berhasil dihapus.'))
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageVouchers::route('/'),
        ];
    }
}
