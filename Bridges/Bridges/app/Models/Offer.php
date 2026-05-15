<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Offer extends Model
{
    protected $table = 'offers';

    protected $fillable = [
        'salary', 'bonus', 'status', 'expire_date',
    ];

    protected $casts = [
        'expire_date' => 'date',
        'salary'      => 'decimal:2',
    ];

    public function offerLetter(): HasOne
    {
        return $this->hasOne(OfferLetter::class, 'offer_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'offer_id');
    }
}
