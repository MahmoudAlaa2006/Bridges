<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Approval extends Model
{
    protected $table = 'approvals';
    protected $primaryKey = 'approval_id';

    protected $fillable = [
        'requisition_id', 'approver_id', 'status', 'reason',
    ];

    public function jobRequisition(): BelongsTo
    {
        return $this->belongsTo(JobRequisition::class, 'requisition_id', 'requisition_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
