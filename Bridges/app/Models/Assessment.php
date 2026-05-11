<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assessment extends Model
{
    protected $table = 'assessments';

    protected $fillable = [
        'assessment_id', 'candidate_id', 'job_id', 'start_timestamp',
        'duration_minutes', 'status', 'flagged_for_review', 'focus_loss_count',
    ];

    // AssessmentStatus enum values (from class diagram)
    const STATUSES = ['ACTIVE', 'SUBMITTED', 'FLAGGED', 'GRADED', 'COOLDOWN'];

    protected $casts = [
        'start_timestamp'    => 'datetime',
        'flagged_for_review' => 'boolean',
    ];

    public function focusLossLogs(): HasMany
    {
        return $this->hasMany(FocusLossLog::class, 'assessment_id');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'assessment_id');
    }
}
