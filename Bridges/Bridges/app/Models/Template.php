<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = 'templates';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Easy_Count',
        'Medium_Count',
        'Hard_Count',
        'MCQ_Count',
        'Written_Count',
        'Code_Count'
    ];

    /*
    // Relationships
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_ID', 'job_id');
    }
    */
}
