<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransitionRule extends Model
{
    protected $table = 'transition_rules';
    protected $primaryKey = 'rule_id';

    protected $fillable = [
        'requisition_id', 'from_stage', 'to_stage', 'min_match_score',
    ];

    public function jobRequisitions(): HasMany
    {
        return $this->hasMany(JobRequisition::class, 'rule_id', 'rule_id');
    }
}
