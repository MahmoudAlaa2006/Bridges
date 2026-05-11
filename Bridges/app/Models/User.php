<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * User model for authentication and role-based access.
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name', 
        'last_name', 
        'age', 
        'email', 
        'password',
        'role', 
        'current_stage', 
        'resume', 
        'offer_id', 
        'has_capacity',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'has_capacity'  => 'boolean',
            'current_stage' => 'string',
        ];
    }

    // Stage enum values (from class diagram)
    const STAGES = ['technical_test', 'interview', 'offer', 'rejected'];

    /**
     * Availability windows for the user (candidate).
     */
    public function availabilityWindows(): HasMany
    {
        return $this->hasMany(AvailabilityWindow::class, 'candidate_user_id');
    }

    /**
     * Interviews assigned to the user.
     */
    public function interviews(): HasMany
    {
        return $this->hasMany(Interview::class, 'user_id');
    }

    /**
     * Feedback provided by the user.
     */
    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class, 'user_id');
    }

    /**
     * Panels the user is part of.
     */
    public function panels(): HasMany
    {
        return $this->hasMany(Panel::class, 'user_id');
    }

    /**
     * Extension requests for senior interviewers.
     */
    public function extensionRequests(): HasMany
    {
        return $this->hasMany(Request::class, 'senior_interviewer_user_id');
    }

    /**
     * Audit logs related to the user.
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class, 'user_id');
    }

    /**
     * Applications submitted by the candidate.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'candidate_user_id');
    }

    /**
     * Offer associated with the user.
     */
    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }

    /**
     * Approvals performed by the user.
     */
    public function approvals(): HasMany
    {
        return $this->hasMany(Approval::class, 'approver_id');
    }

    /**
     * Request logs for the user.
     */
    public function requestLogs(): HasMany
    {
        return $this->hasMany(RequestLog::class, 'user_id');
    }

    /**
     * Get the user's full name.
     */
    public function getNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    /**
     * Set the user's name by splitting into first and last names.
     */
    public function setNameAttribute($value): void
    {
        $parts = explode(' ', (string)$value, 2);
        $this->attributes['first_name'] = $parts[0] ?? '';
        $this->attributes['last_name'] = $parts[1] ?? '';
    }
}

