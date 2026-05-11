<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FocusLossLog extends Model
{
    protected $table = 'focus_loss_logs';
    protected $primaryKey = 'log_id';

    protected $fillable = [
        'assessment_id', 'event_type', 'timestamp', 'count',
    ];

    // EventType enum values (from class diagram)
    const EVENT_TYPES = ['TAB_SWITCH', 'WINDOW_BLUR', 'PAGE_UNLOAD', 'COPY_PASTE', 'FOCUS_LOST'];

    protected $casts = [
        'timestamp' => 'datetime',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class, 'assessment_id');
    }
}
