<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestCase extends Model
{
    protected $table = 'test_cases';
    protected $primaryKey = 'test_case_id';

    protected $fillable = [
        'code_question_bank_question_id', 'input',
        'expected_output', 'actual_output', 'passed',
    ];

    protected $casts = [
        'passed' => 'boolean',
    ];

    public function codeQuestion(): BelongsTo
    {
        return $this->belongsTo(
            CodeQuestion::class,
            'code_question_bank_question_id',
            'question_bank_question_id'
        );
    }
}
