<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserData extends Model
{
    use HasFactory;


    protected $fillable = [
        "key",
        "value",
        "bot_user_id"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(BotUser::class, "bot_user_id");
    }
}
