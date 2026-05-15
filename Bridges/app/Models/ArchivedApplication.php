<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArchivedApplication extends Model
{
    protected $table = 'archived_applications';
    protected $primaryKey = 'archived_app_id';

    protected $fillable = [
        'application_record_id', 'candidate_id',
        'status', 'last_activity_date', 'archived_at',
    ];

    protected $casts = [
        'last_activity_date' => 'datetime',
        'archived_at'        => 'datetime',
    ];

    public function applicationRecord(): BelongsTo
    {
        return $this->belongsTo(
            ApplicationRecord::class,
            'application_record_id',
            'application_record_id'
        );
    }
}
