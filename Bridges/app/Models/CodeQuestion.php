<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CodeQuestion extends Model
{
    protected $table = 'code_questions';
    protected $primaryKey = 'question_bank_question_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'question_bank_question_id', 'language', 'test_case',
    ];

    public function questionBank(): BelongsTo
    {
        return $this->belongsTo(QuestionBank::class, 'question_bank_question_id', 'question_id');
    }

    public function testCases(): HasMany
    {
        return $this->hasMany(TestCase::class, 'code_question_bank_question_id', 'question_bank_question_id');
    }
}
