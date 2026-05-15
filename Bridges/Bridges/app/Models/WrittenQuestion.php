<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WrittenQuestion extends Model
{
    protected $table      = 'written_questions';

    /**
     * The primary key is also the FK to question_banks.
     * No auto-increment — the value is set manually (same ID as the parent).
     */
    protected $primaryKey = 'question_bank_question_id';
    public    $incrementing = false;
    protected $keyType    = 'int';

    protected $fillable = [
        'question_bank_question_id',
        'word_limit',
        'rubric',
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
}
