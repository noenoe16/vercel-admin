<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getGloballySearchableAttributes(): array
    {
        return ['title'];
    }

    
    
    public static function getNavigationGroup(): ?string
    {
        return __('Blog & Media');
    }

    public static function getNavigationLabel(): string
    {
        return __('Banner Promo');
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
        return __('Total Banner Promo');
    }

    public static function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Konten Banner'))
                    ->description(__('Detail promosi atau banner utama.'))
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(__('Judul'))
                            ->placeholder(__('Masukkan judul banner'))
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('image_url')
                            ->label(__('Gambar Banner'))
                            ->image()
                            ->directory('banners')
                            ->required(),
                        Forms\Components\TextInput::make('link_url')
                            ->label(__('URL Pengalihan'))
                            ->placeholder(__('https://example.com'))
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make(__('Konfigurasi'))
                    ->description(__('Pengaturan visibilitas banner dan urutan tampilan.'))
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label(__('Status Aktif'))
                            ->required(),
                        Forms\Components\TextInput::make('sort_order')
                            ->label(__('Prioritas Tampilan'))
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->mobileCards()
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('Judul Banner'))
                    ->searchable()
                    ->sortable()
                    ->alignment('center'),
                Tables\Columns\ImageColumn::make('image_url')
                    ->label(__('Pratinjau Gambar'))
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('link_url')
                    ->label(__('Link Pengalihan'))
                    ->searchable()
                    ->alignment('center'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('Status'))
                    ->alignment('center')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label(__('Prioritas'))
                    ->numeric()
                    ->sortable()
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Dibuat Pada'))
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
                            ->title(__('Banner diperbarui'))
                            ->body(__('Banner telah berhasil diperbarui.'))
                    ),
                Tables\Actions\DeleteAction::make()
                    ->button()
                    ->color('danger')
                    ->size('lg')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title(__('Banner dihapus'))
                            ->body(__('Banner telah berhasil dihapus.'))
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
            'index' => Pages\ManageBanners::route('/'),
        ];
    }
}
