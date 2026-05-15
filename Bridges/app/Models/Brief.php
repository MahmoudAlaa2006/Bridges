<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brief extends Model
{
    use HasFactory;
    protected $table = 'briefs';

    protected $fillable = [
        'interview_id', 'content', 'is_read_only', 'last_updated',
    ];

    protected $casts = [
        'is_read_only' => 'boolean',
        'last_updated' => 'datetime',
    ];

    public function interview(): BelongsTo
    {
        return $this->belongsTo(Interview::class, 'interview_id');
    }
}
