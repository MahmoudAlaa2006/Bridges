<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GradeResult extends Model
{
    protected $table = 'grade_results';
    protected $primaryKey = 'question_bank_question_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'question_bank_question_id', 'submission_id',
        'score', 'max_score', 'passed', 'attribu_breakdown',
    ];

    protected $casts = [
        'passed' => 'boolean',
    ];

    public function questionBank(): BelongsTo
    {
        return $this->belongsTo(QuestionBank::class, 'question_bank_question_id', 'question_id');
    }

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class, 'submission_id', 'submission_id');
    }
}
