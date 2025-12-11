<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TelegramLog extends Model
{
    protected $table = 'telegram_logs';

    protected $fillable = [
        'telegram_bot_id',
        'type',
        'action',
        'request_data',
        'response_data',
        'message',
    ];

    protected $casts = [
        'request_data' => 'array',
        'response_data' => 'array',
    ];

    public function telegramBot(): BelongsTo
    {
        return $this->belongsTo(TelegramBot::class);
    }
}
