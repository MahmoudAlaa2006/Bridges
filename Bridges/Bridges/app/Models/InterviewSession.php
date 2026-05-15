<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InterviewSession extends Model
{
    use HasFactory;

    protected $table = 'interview_sessions';

    protected $fillable = [
        'interview_id', 'started_at', 'ended_at', 'status',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_ENDED = 'ended';

    public function interview(): BelongsTo
    {
        return $this->belongsTo(Interview::class, 'interview_id');
    }
}