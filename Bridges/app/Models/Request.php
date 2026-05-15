<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Request extends Model
{
    protected $table = 'requests';

    protected $fillable = [
        'senior_interviewer_user_id', 'reason', 'extra_minutes', 'status',
    ];

    // Status enum values (from class diagram)
    const STATUSES = ['PENDING', 'APPROVED', 'REJECTED'];

    public function seniorInterviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'senior_interviewer_user_id');
    }

    public function requestLogs(): HasMany
    {
        return $this->hasMany(RequestLog::class, 'request_id');
    }
}
