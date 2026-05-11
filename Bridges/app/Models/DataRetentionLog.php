<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataRetentionLog extends Model
{
    protected $table = 'data_retention_logs';
    protected $primaryKey = 'retention_log_id';

    protected $fillable = [
        'action', 'report_id', 'candidate_id', 'action_date', 'reason',
    ];

    protected $casts = [
        'action_date' => 'datetime',
    ];
}
