<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bank extends Model
{
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}
