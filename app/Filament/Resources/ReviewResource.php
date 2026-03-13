<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?int $navigationSort = 6;

    protected static ?string $recordTitleAttribute = 'comment';

    public static function getGloballySearchableAttributes(): array
    {
        return ['comment'];
    }

    
    
    public static function getNavigationGroup(): ?string
    {
        return __('Blog & Media');
    }

    public static function getNavigationLabel(): string
    {
        return __('Ulasan Pelanggan');
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
        return __('Total Ulasan Pelanggan');
    }

    public static function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Konteks Ulasan'))
                    ->description(__('Peserta dan layanan yang terlibat dalam ulasan ini.'))
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label(__('Pengulas'))
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('wedding_organizer_id')
                            ->label(__('Studio Target'))
                            ->relationship('weddingOrganizer', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('package_id')
                            ->label(__('Paket Target'))
                            ->relationship('package', 'name')
                            ->searchable()
                            ->preload(),
                    ])->columns(3),

                Forms\Components\Section::make(__('Rating & Umpan Balik'))
                    ->description(__('Evaluasi pengguna dan komentar detail.'))
                    ->schema([
                        Forms\Components\Select::make('rating')
                            ->label(__('Skor Rating'))
                            ->searchable()
                            ->options([
                                1 => __('1 Bintang'),
                                2 => __('2 Bintang'),
                                3 => __('3 Bintang'),
                                4 => __('4 Bintang'),
                                5 => __('5 Bintang'),
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('comment')
                            ->label(__('Komentar Pengulas'))
                            ->columnSpanFull(),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('Pengulas'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('weddingOrganizer.name')
                    ->label(__('Studio Makeup'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('package.name')
                    ->label(__('Paket'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating')
                    ->label(__('Rating'))
                    ->numeric()
                    ->sortable()
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('comment')
                    ->label(__('Komentar Ulasan'))
                    ->searchable()
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Tanggal'))
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
                            ->title(__('Ulasan diperbarui'))
                            ->body(__('Ulasan telah berhasil diperbarui.'))
                    ),
                Tables\Actions\DeleteAction::make()
                    ->button()
                    ->color('danger')
                    ->size('lg')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title(__('Ulasan dihapus'))
                            ->body(__('Ulasan telah berhasil dihapus.'))
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
            'index' => Pages\ManageReviews::route('/'),
        ];
    }
}
