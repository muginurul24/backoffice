<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Readed extends Model
{
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function memo(): BelongsTo
    {
        return $this->belongsTo(Memo::class);
    }
}
