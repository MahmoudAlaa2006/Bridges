<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApplicationRecord extends Model
{
    protected $table = 'application_records';
    protected $primaryKey = 'application_record_id';

    protected $fillable = [
        'status', 'last_activity_date',
    ];

    protected $casts = [
        'last_activity_date' => 'datetime',
    ];

    public function archivedApplications(): HasMany
    {
        return $this->hasMany(ArchivedApplication::class, 'application_record_id', 'application_record_id');
    }
}
