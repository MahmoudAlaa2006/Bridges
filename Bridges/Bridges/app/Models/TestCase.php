<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestCase extends Model
{
    protected $table      = 'test_cases';
    protected $primaryKey = 'test_case_id';

    protected $fillable = [
        'code_question_id',    // FK → code_questions.question_bank_question_id
        'input',
        'expected_output',
        'actual_output',       // filled after candidate code is run
        'passed',
    ];

    protected $casts = [
        'passed' => 'boolean',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function codeQuestion(): BelongsTo
    {
        return $this->belongsTo(
            CodeQuestion::class,
            'code_question_id',                // FK on this table
            'questions_bank_question_id'        // PK on code_questions
        );
    }
}
