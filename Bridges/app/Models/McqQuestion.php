<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class McqQuestion extends Model
{
    protected $table = 'mcq_questions';
    protected $primaryKey = 'question_bank_question_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'question_bank_question_id', 'options', 'correct_option_index',
    ];

    public function questionBank(): BelongsTo
    {
        return $this->belongsTo(QuestionBank::class, 'question_bank_question_id', 'question_id');
    }
}
