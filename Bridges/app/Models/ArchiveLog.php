<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchiveLog extends Model
{
    protected $table = 'archive_logs';
    protected $primaryKey = 'archive_log_id';

    protected $fillable = [
        'run_date', 'entity_type', 'action_type',
        'record_id', 'count_before', 'count_after', 'record_ids',
    ];

    protected $casts = [
        'run_date' => 'datetime',
    ];
}
