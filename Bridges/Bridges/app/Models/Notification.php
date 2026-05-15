<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'notification_id',
        'recipient_id',
        'subject',
        'message',
        'type',
        'read_at'
    ];

    public function markRead()
    {
        $this->update(['read_at' => now()]);
    }
}
