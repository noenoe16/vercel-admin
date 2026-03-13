<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\User;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'order_number';

    public static function getGloballySearchableAttributes(): array
    {
        return ['order_number'];
    }

    
    
    public static function getNavigationGroup(): ?string
    {
        return __('Transaksi');
    }

    public static function getNavigationLabel(): string
    {
        return __('Daftar Pesanan');
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
        return __('Manajemen Pesanan Pelanggan');
    }

    public static function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Pelanggan & Layanan'))
                    ->description(__('Hubungkan pesanan ke pelanggan dan paket yang dipilih.'))
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label(__('Pelanggan'))
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('package_id')
                            ->label(__('Paket Layanan'))
                            ->relationship('package', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make(__('Informasi Pesanan'))
                    ->description(__('Detail utama mengenai nomor pesanan dan jadwal.'))
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->label(__('Referensi Pesanan'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('booking_date')
                            ->label(__('Tanggal Acara'))
                            ->required(),
                        Forms\Components\Textarea::make('notes')
                            ->label(__('Catatan'))
                            ->columnSpan('full'),
                    ])->columns(2),

                Forms\Components\Section::make(__('Status Keuangan'))
                    ->description(__('Pelacakan harga dan pembayaran untuk transaksi ini.'))
                    ->schema([
                        Forms\Components\TextInput::make('total_price')
                            ->label(__('Total Harga'))
                            ->required()
                            ->numeric()
                            ->prefix('IDR'),
                        Forms\Components\Select::make('status')
                            ->label(__('Status Pesanan'))
                            ->options([
                                'pending' => __('Tertunda'),
                                'confirmed' => __('Dikonfirmasi'),
                                'cancelled' => __('Dibatalkan'),
                                'completed' => __('Selesai'),
                            ])
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('payment_status')
                            ->label(__('Status Pembayaran'))
                            ->options([
                                'pending' => __('Tertunda'),
                                'paid' => __('Lunas'),
                                'failed' => __('Gagal'),
                            ])
                            ->searchable()
                            ->required(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->mobileCards()
            ->mobileCardFeatured('total_amount', 'rose')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('Pelanggan'))
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('package.name')
                    ->label(__('Paket Layanan'))
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_number')
                    ->label(__('No. Pesanan'))
                    ->searchable()
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('total_price')
                    ->label(__('Harga'))
                    ->money('IDR')
                    ->sortable()
                    ->alignment('right'),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => __('Tertunda'),
                        'confirmed' => __('Dikonfirmasi'),
                        'cancelled' => __('Dibatalkan'),
                        'completed' => __('Selesai'),
                        default => $state,
                    })
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label(__('Pembayaran'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => __('Tertunda'),
                        'paid' => __('Lunas'),
                        'failed' => __('Gagal'),
                        default => $state,
                    })
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('booking_date')
                    ->label(__('Tanggal Acara'))
                    ->date()
                    ->sortable()
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('notes')
                    ->label(__('Catatan'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Tanggal Pesan'))
                    ->dateTime()
                    ->sortable()
                    ->alignment('center')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Terakhir Diperbarui'))
                    ->dateTime()
                    ->sortable()
                    ->alignment('center')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('chat')
                    ->label(__('Hubungi'))
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->button()
                    ->url(function (Order $record) {
                        $authId = \Illuminate\Support\Facades\Auth::id();
                        $customerId = $record->user_id;
                        $adminId = \App\Models\User::role('super_admin')->first()?->id ?? 1;

                        $targetId = ($authId == $customerId) ? $adminId : $customerId;

                        $inbox = \App\Models\Inbox::query()
                            ->whereJsonContains('user_ids', (int) $authId)
                            ->whereJsonContains('user_ids', (int) $targetId)
                            ->get()
                            ->first(function ($inbox) use ($authId, $targetId) {
                                $ids = collect($inbox->user_ids)->unique();

                                return $ids->contains($authId) && $ids->contains($targetId) && $ids->count() <= 2;
                            });

                        if (! $inbox) {
                            $inbox = \App\Models\Inbox::create([
                                'user_ids' => collect([(int) $authId, (int) $targetId])->unique()->values()->toArray(),
                                'title' => __('Diskusi Order #').$record->order_number,
                            ]);

                            \App\Models\Message::create([
                                'inbox_id' => $inbox->id,
                                'user_id' => $authId,
                                'message' => __("Halo, saya ingin mendiskusikan Pesanan #").$record->order_number.".",
                                'read_by' => [$authId],
                            ]);
                        }

                        return \App\Filament\Pages\MessagesPage::getUrl(['id' => $inbox->id]);
                    }),
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
                            ->title(__('Pesanan diperbarui'))
                            ->body(__('Pesanan telah berhasil diperbarui.'))
                    ),
                Tables\Actions\DeleteAction::make()
                    ->button()
                    ->color('danger')
                    ->size('lg')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title(__('Pesanan dihapus'))
                            ->body(__('Pesanan telah berhasil dihapus.'))
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageOrders::route('/'),
        ];
    }
}
