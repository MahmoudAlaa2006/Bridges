<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Interview extends Model
{
    use HasFactory;
    protected $table = 'interviews';

    protected $fillable = [
        'user_id', 'application_id', 'slot_id', 'content', 'presentation_notes', 'get_date', 'status',
    ];

    protected $casts = [
        'get_date'  => 'datetime',
    ];

    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_COMPLETED = 'completed';
    const STATUS_PENDING_FEEDBACK = 'pending_feedback';

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id', 'application_id');
    }

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

    public function session()
    {
        return $this->hasOne(InterviewSession::class, 'interview_id');
    }

    public function extensionRequests()
    {
        return $this->hasMany(TimeExtensionRequest::class, 'interview_id');
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class, 'interview_id');
    }

    public function brief(): HasOne
    {
        return $this->hasOne(Brief::class, 'interview_id');
    }

    public function codeSession(): HasOne
    {
        return $this->hasOne(CodeSession::class, 'interview_id');
    }



    public function escalationLog(): HasOne
    {
        return $this->hasOne(EscalationLog::class, 'interview_id');
    }
}
