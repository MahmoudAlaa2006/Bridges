<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CodeQuestion extends Model
{
    protected $table      = 'code_questions';

    /**
     * The primary key is also the FK to question_banks.
     * No auto-increment — the value is set manually (same ID as the parent).
     */
    protected $primaryKey = 'question_bank_question_id';
    public    $incrementing = false;
    protected $keyType    = 'int';

    protected $fillable = [
        'question_bank_question_id',
        'language',           // e.g. 'php', 'python', 'java'
        'test_case',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function questionBank(): BelongsTo
    {
        return $this->belongsTo(
            QuestionBank::class,
            'question_bank_question_id',
            'question_id'
        );
    }

    public function testCases(): HasMany
    {
        return $this->hasMany(
            TestCase::class,
            'code_question_id',                // FK on test_cases
            'question_bank_question_id'        // PK on code_questions
        );
    }
}
