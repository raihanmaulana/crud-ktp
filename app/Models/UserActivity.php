<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserActivity extends Model
{
    protected $fillable = ['user_id', 'activity', 'url'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
