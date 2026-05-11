<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Interview extends Model
{
    protected $table = 'interviews';

    protected $fillable = [
        'user_id', 'slot_id', 'content', 'get_date', 'is_finish',
    ];

    protected $casts = [
        'is_finish' => 'boolean',
        'get_date'  => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function slot(): BelongsTo
    {
        return $this->belongsTo(Slot::class, 'slot_id');
    }

    public function panels(): HasMany
    {
        return $this->hasMany(Panel::class, 'interview_id');
    }

    public function brief(): HasOne
    {
        return $this->hasOne(Brief::class, 'interview_id');
    }

    public function codeSession(): HasOne
    {
        return $this->hasOne(CodeSession::class, 'interview_id');
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class, 'interview_id');
    }

    public function escalationLog(): HasOne
    {
        return $this->hasOne(EscalationLog::class, 'interview_id');
    }
}
