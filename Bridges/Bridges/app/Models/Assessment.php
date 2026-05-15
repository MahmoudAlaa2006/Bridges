<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $table = 'assessments';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'candidate_id',
        'job_id',
        'template_id',
        'status',
        'focusLossCount',
        'submitted_at',
        'focus_loss_threshold',
        'flag_for_review',
    ];

    protected $casts = [
        'submitted_at'   => 'datetime',
        'flag_for_review' => 'boolean',
    ];

    const STATUSES = ['PENDING','ACTIVE', 'SUBMITTED', 'FLAGGED', 'GRADED', 'COOLDOWN'];

 /*
    // Relationships
    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id', 'id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }

    public function template()
    {
        return $this->belongsTo(Template::class, 'template_id', 'id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'AssessmentID', 'ID');
    }

    public function focusLossLogs()
    {
        return $this->hasMany(FocusLossLog::class, 'AssessmentID', 'ID');
    }
        */
}

