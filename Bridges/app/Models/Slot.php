<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slot extends Model
{
    use HasFactory;
    protected $table = 'slots';

    protected $fillable = [
        'interview_id', 'date', 'start_time', 'end_time', 'time_zone',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function interview(): BelongsTo
    {
        return $this->belongsTo(Interview::class, 'interview_id');
    }
}
