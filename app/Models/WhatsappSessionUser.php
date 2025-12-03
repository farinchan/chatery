<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappSessionUser extends Model
{
    protected $table = 'whatsapp_session_users';

    protected $fillable = [
        'whatsapp_session_id',
        'user_id',
        'role',
        'session_token',
        'status',
    ];

    public function whatsapp_session()
    {
        return $this->belongsTo(WhatsappSession::class, 'whatsapp_session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
