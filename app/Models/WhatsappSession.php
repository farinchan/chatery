<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappSession extends Model
{
    protected $table = 'whatsapp_sessions';

    protected $fillable = [
        'session_name',
        'session_webhook_url',
        'is_active',
    ];

    public function whatsapp_session_users()
    {
        return $this->hasMany(WhatsappSessionUser::class, 'whatsapp_session_id');
    }
}
