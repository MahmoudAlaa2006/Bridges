<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamTemplate extends Model
{
    protected $table = 'exam_templates';
    protected $primaryKey = 'template_id';

    protected $fillable = [
        'mcq_easy', 'mcq_medium', 'mcq_hard',
        'written', 'coding', 'requisition_id',
    ];

    public function jobRequisition(): BelongsTo
    {
        return $this->belongsTo(JobRequisition::class, 'requisition_id', 'requisition_id');
    }
}
