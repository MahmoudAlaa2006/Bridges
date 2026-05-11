<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfferLetter extends Model
{
    protected $table = 'offer_letters';
    protected $primaryKey = 'offer_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'offer_id', 'content', 'create_date',
    ];

    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }
}
