<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\Messages\MediaCollectionType;
use App\Models\Traits\HasMediaConvertionRegistrations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Message extends Model implements HasMedia
{
    use HasMediaConvertionRegistrations, SoftDeletes;

    protected $table = 'fm_messages';

    protected $fillable = [
        'inbox_id',
        'message',
        'user_id',
        'read_by',
        'read_at',
        'notified',
    ];

    protected function casts(): array
    {
        return [
            'read_by' => 'array',
            'read_at' => 'array',
            'notified' => 'array',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(MediaCollectionType::FILAMENT_MESSAGES->value)
            ->registerMediaConversions($this->modelMediaConvertionRegistrations());
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Media::class, 'model')
            ->where('collection_name', MediaCollectionType::FILAMENT_MESSAGES);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function inbox(): BelongsTo
    {
        return $this->belongsTo(Inbox::class);
    }
}
