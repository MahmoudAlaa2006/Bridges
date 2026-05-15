<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobRecord extends Model
{
    protected $table = 'job_records';
    protected $primaryKey = 'job_record_id';

    protected $fillable = [
        'status', 'closed_at',
    ];

    protected $casts = [
        'closed_at' => 'datetime',
    ];

    public function archivedJobs(): HasMany
    {
        return $this->hasMany(ArchivedJob::class, 'job_record_id', 'job_record_id');
    }
}
