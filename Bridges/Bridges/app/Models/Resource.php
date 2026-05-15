<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $table = 'resources';
    protected $primaryKey = 'resource_id';

    protected $fillable = [
        'entity_type', 'entity_id', 'action', 'granted', 'user_role',
    ];
}
