<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Panel extends Model
{
    use HasFactory;
    protected $table = 'panels';

    protected $fillable = [
        'interview_id', 'user_id',
    ];

    public function interview(): BelongsTo
    {
        return $this->belongsTo(Interview::class, 'interview_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
