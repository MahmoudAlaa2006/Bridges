<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EscalationLog extends Model
{
    protected $table = 'escalation_logs';
    protected $primaryKey = 'escalation_id';

    protected $fillable = [
        'interview_id', 'reminder_sent_at', 'escalation_sent_at', 'resolved_at',
    ];

    protected $casts = [
        'reminder_sent_at'   => 'datetime',
        'escalation_sent_at' => 'datetime',
        'resolved_at'        => 'datetime',
    ];

    public function interview(): BelongsTo
    {
        return $this->belongsTo(Interview::class, 'interview_id');
    }
}
