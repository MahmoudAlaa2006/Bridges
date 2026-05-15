<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class McqQuestion extends Model
{
    protected $table      = 'mcq_questions';

    /**
     * The primary key is also the FK to question_banks.
     * No auto-increment — the value is set manually (same ID as the parent).
     */
    protected $primaryKey = 'question_bank_question_id';
    public    $incrementing = false;
    protected $keyType    = 'int';

    protected $fillable = [
        'question_bank_question_id',
        'options',              // JSON array of strings
        'correct_option_index', // Integer index
    ];

    protected $casts = [
        'options' => 'array',
    ];

    const CORRECT_OPTIONS = ['A', 'B', 'C', 'D'];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function questionBank(): BelongsTo
    {
        return $this->belongsTo(
            QuestionBank::class,
            'question_bank_question_id',   // FK on this table
            'question_id'                  // PK on question_banks
        );
    }
}
