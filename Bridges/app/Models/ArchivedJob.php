<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArchivedJob extends Model
{
    protected $table = 'archived_jobs';
    protected $primaryKey = 'archived_job_id';

    protected $fillable = [
        'job_record_id', 'status', 'closed_at', 'archived_at',
    ];

    protected $casts = [
        'closed_at'   => 'datetime',
        'archived_at' => 'datetime',
    ];

    public function jobRecord(): BelongsTo
    {
        return $this->belongsTo(JobRecord::class, 'job_record_id', 'job_record_id');
    }
}
