<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class QuestionBank extends Model
{
    protected $table = 'question_banks';
    protected $primaryKey = 'question_id';

    protected $fillable = [
        'job_id', 'text', 'difficulty', 'topic', 'points',
    ];

    // Difficulty enum values (from class diagram)
    const DIFFICULTIES = ['EASY', 'MEDIUM', 'HARD'];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id', 'job_id');
    }

    public function mcqQuestion(): HasOne
    {
        return $this->hasOne(McqQuestion::class, 'question_bank_question_id', 'question_id');
    }

    public function writtenQuestion(): HasOne
    {
        return $this->hasOne(WrittenQuestion::class, 'question_bank_question_id', 'question_id');
    }

    public function codeQuestion(): HasOne
    {
        return $this->hasOne(CodeQuestion::class, 'question_bank_question_id', 'question_id');
    }

    public function gradeResult(): HasOne
    {
        return $this->hasOne(GradeResult::class, 'question_bank_question_id', 'question_id');
    }
}
