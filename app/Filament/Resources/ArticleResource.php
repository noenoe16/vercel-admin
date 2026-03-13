<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use App\Models\User;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'title';

    
    
    public static function getNavigationGroup(): ?string
    {
        return __('Blog & Media');
    }

    public static function getNavigationLabel(): string
    {
        return __('Artikel Blog');
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
        return __('Total Artikel Blog');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'slug', 'content'];
    }

    public static function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Informasi Artikel'))
                    ->description(__('Detail tentang artikel dan penulisnya.'))
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(__('Judul'))
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', str($state)->slug())),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignorable: fn ($record) => $record)
                            ->maxLength(255),
                        Forms\Components\Select::make('author_id')
                            ->label(__('Penulis'))
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make(__('Konten'))
                    ->description(__('Tulis konten utama artikel Anda.'))
                    ->schema([
                        Forms\Components\RichEditor::make('content')
                            ->label(__('Konten'))
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make(__('Media & Penerbitan'))
                    ->description(__('Gambar unggulan artikel, video, dan status publikasi.'))
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('article_image')
                            ->label(__('Gambar Utama Artikel'))
                            ->collection('article-images')
                            ->image()
                            ->imageEditor()
                            ->maxSize(102400000), // 100GB
                        Forms\Components\Group::make([
                            Forms\Components\Toggle::make('is_published')
                                ->label(__('Diterbitkan'))
                                ->required(),
                            Forms\Components\DateTimePicker::make('published_at')
                                ->label(__('Tanggal Publikasi')),
                        ])->columns(1),
                    ])->columns(2),

                Forms\Components\Section::make(__('Video Artikel'))
                    ->description(__('Tambahkan video pendukung untuk artikel ini.'))
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('videos')
                            ->label(__('Video Artikel'))
                            ->collection('videos')
                            ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/ogg', 'video/quicktime'])
                            ->maxSize(102400000) // 100GB
                            ->helperText(__('Upload 1 video untuk artikel ini. Format: MP4, WebM, MOV. Maks 100GB.'))
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->mobileCards()
            ->mobileCardFeatured('title', 'sky')
            ->columns([
                Tables\Columns\TextColumn::make('author.name')
                    ->label(__('Penulis'))
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('Judul Artikel'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label(__('Slug'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ImageColumn::make('image_url')
                    ->label(__('Gambar Utama'))
                    ->alignment('center'),
                Tables\Columns\IconColumn::make('is_published')
                    ->label(__('Diterbitkan'))
                    ->alignment('center')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label(__('Tanggal Terbit'))
                    ->dateTime()
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
                            ->title(__('Artikel diperbarui'))
                            ->body(__('Artikel telah berhasil diperbarui.'))
                    ),
                Tables\Actions\DeleteAction::make()
                    ->button()
                    ->color('danger')
                    ->size('lg')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title(__('Artikel dihapus'))
                            ->body(__('Artikel telah berhasil dihapus.'))
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
            'index' => Pages\ManageArticles::route('/'),
        ];
    }
}
