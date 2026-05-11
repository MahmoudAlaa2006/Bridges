<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AvailabilityWindow extends Model
{
    protected $table = 'availability_windows';

    protected $fillable = [
        'candidate_user_id', 'date', 'start_time', 'end_time', 'time_zone',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'candidate_user_id');
    }
}
