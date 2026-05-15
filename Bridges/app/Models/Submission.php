<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Submission extends Model
{
    protected $table = 'submissions';
    protected $primaryKey = 'submission_id';

    protected $fillable = [
        'assessment_id', 'submitted_at', 'submission_type',
        'plagiarism_flag', 'matched_template_id', 'similarity_score', 'total_score',
    ];

    // SubmitType enum values (from class diagram)
    const SUBMIT_TYPES = ['MANUAL_SUBMIT', 'AUTO_SUBMIT'];

    protected $casts = [
        'submitted_at'    => 'datetime',
        'plagiarism_flag' => 'boolean',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class, 'assessment_id');
    }

    public function gradeResults(): HasMany
    {
        return $this->hasMany(GradeResult::class, 'submission_id', 'submission_id');
    }
}
