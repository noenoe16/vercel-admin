<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Inbox extends Model
{
    use SoftDeletes;

    protected $table = 'fm_inboxes';

    protected $fillable = [
        'title',
        'user_ids'
    ];

    protected function casts(): array
    {
        return [
            'user_ids' => 'array',
        ];
    }

    protected function inboxTitle(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->title) {
                    return $this->title;
                }

                $authId = Auth::id();
                $userIds = collect($this->user_ids);
                
                $otherParticipants = $userIds->filter(fn ($id) => $id != $authId);

                if ($otherParticipants->isEmpty()) {
                    return Auth::user()?->full_name ?? 'Diri Sendiri';
                }

                return $otherParticipants->map(function ($userId) {
                    return \App\Models\User::find($userId)?->full_name;
                })->values()->filter()->implode(', ') ?: 'Unknown';
            }
        );
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function latestMessage(): Message | null
    {
        return $this->messages()->latest()->first();
    }

    public function otherUsers(): Attribute
    {
        return Attribute::make(
            get: fn () => \App\Models\User::whereIn('id', $this->user_ids)->whereNot('id', Auth::id())->get()
        );
    }
}
