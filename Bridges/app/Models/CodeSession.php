<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CodeSession extends Model
{
    protected $table = 'code_sessions';

    protected $fillable = [
        'interview_id', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function interview(): BelongsTo
    {
        return $this->belongsTo(Interview::class, 'interview_id');
    }
}
