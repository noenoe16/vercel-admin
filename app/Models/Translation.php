<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $fillable = [
        'source_text',
        'source_hash',
        'target_locale',
        'translated_text',
    ];
}
