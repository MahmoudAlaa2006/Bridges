<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentTemplate extends Model
{
    protected $table = 'assessment_templates';
    protected $primaryKey = 'job_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'job_id', 'easy_count', 'medium_count', 'hard_count',
        'status', 'topics', 'randomise_order',
    ];

    protected $casts = [
        'randomise_order' => 'boolean',
    ];
}
