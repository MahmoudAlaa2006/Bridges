<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    protected $table = 'jobs';
    protected $primaryKey = 'job_id';

    protected $fillable = [
        'title', 'department', 'location', 'salary_range',
        'active', 'description', 'benefits', 'requirements',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'job_id', 'job_id');
    }

    public function questionBanks(): HasMany
    {
        return $this->hasMany(QuestionBank::class, 'job_id', 'job_id');
    }

    public function requisitions(): HasMany
    {
        return $this->hasMany(JobRequisition::class, 'job_id', 'job_id');
    }
}
