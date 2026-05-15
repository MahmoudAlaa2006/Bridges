<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $table = 'audit_logs';
    protected $primaryKey = 'log_id';

    protected $fillable = [
        'user_id', 'actor_id', 'actor_role', 'action_type', 'time_stamp',
        'entity_type', 'entity_id', 'field_changed',
        'value_before', 'value_after', 'comments', 'ip_address',
    ];

    protected $casts = [
        'time_stamp' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
