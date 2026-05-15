<?php
// ============================================================
// app/Models/ExamAnswer.php
// ============================================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamAnswer extends Model
{
    protected $fillable = [
        'submission_id', 'question_id', 'question_type',
        'answer_text', 'answer_option',
        'points_awarded', 'points_possible',
        'is_correct', 'grader_feedback',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(ExamSubmission::class, 'submission_id');
    }
}
