<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class JobRequisition extends Model
{
    protected $table = 'job_requisitions';
    protected $primaryKey = 'requisition_id';

    protected $fillable = [
        'title', 'description', 'salary_range', 'department',
        'requirements', 'benefits', 'template_id', 'job_id', 'rule_id', 'status',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id', 'job_id');
    }

    public function transitionRule(): BelongsTo
    {
        return $this->belongsTo(TransitionRule::class, 'rule_id', 'rule_id');
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(Approval::class, 'requisition_id', 'requisition_id');
    }

    public function examTemplate(): HasOne
    {
        return $this->hasOne(ExamTemplate::class, 'requisition_id', 'requisition_id');
    }
}
