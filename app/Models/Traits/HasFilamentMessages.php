<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Inbox;

trait HasFilamentMessages
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function allConversations()
    {
        return Inbox::query()->whereJsonContains('user_ids', $this->id)->orderBy('updated_at', 'desc');
    }
}
