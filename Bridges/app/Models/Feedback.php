<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    protected $fillable = [
        'interview_id', 'user_id', 'score', 'feedback_text', 'role', 
        'escalation_reason', 'is_escalated', 'submitted_at'
    ];

    protected $casts = [
        'is_escalated' => 'boolean',
        'submitted_at' => 'datetime',
    ];

    public function interview(): BelongsTo
    {
        return $this->belongsTo(Interview::class, 'interview_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
