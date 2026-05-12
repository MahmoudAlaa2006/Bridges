<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;
    protected $table = 'applications';
    protected $primaryKey = 'application_id';

    protected $fillable = [
        'candidate_user_id', 'job_id', 'status', 'match_score', 'shortlisted',
    ];

    protected $casts = [
        'shortlisted' => 'boolean',
    ];

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'candidate_user_id');
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id', 'job_id');
    }

    public function shortlist(): HasOne
    {
        return $this->hasOne(Shortlist::class, 'application_id', 'application_id');
    }
}
