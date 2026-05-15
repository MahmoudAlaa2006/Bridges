<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestLog extends Model
{
    protected $table = 'request_logs';
    protected $primaryKey = 'request_log_id';

    protected $fillable = [
        'request_id', 'reason', 'request_time', 'user_id',
    ];

    protected $casts = [
        'request_time' => 'datetime',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(Request::class, 'request_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
