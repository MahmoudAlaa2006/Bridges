<?php
// ============================================================
// app/Models/ExamSubmission.php
// ============================================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamSubmission extends Model
{
    protected $fillable = [
        'assessment_id', 'user_id',
        'started_at', 'submitted_at',
        'mcq_score', 'written_score', 'code_score',
        'total_score', 'max_score', 'status',
    ];

    protected $casts = [
        'started_at'   => 'datetime',
        'submitted_at' => 'datetime',
    ];

    /** The assessment this submission belongs to */
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    /** All individual answers belonging to this submission */
    public function answers(): HasMany
    {
        return $this->hasMany(ExamAnswer::class, 'submission_id');
    }

    /** Percentage score (0-100) */
    public function percentageScore(): float
    {
        if ($this->max_score === 0) return 0;
        return round(($this->total_score / $this->max_score) * 100, 1);
    }

    /** Letter grade derived from percentage */
    public function letterGrade(): string
    {
        $pct = $this->percentageScore();
        return match (true) {
            $pct >= 90 => 'A',
            $pct >= 80 => 'B',
            $pct >= 70 => 'C',
            $pct >= 60 => 'D',
            default    => 'F',
        };
    }
}
