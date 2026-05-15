<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['first_name', 'last_name', 'email', 'password', 'age', 'role', 'current_stage', 'resume'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the candidate's job applications.
     */
    public function applications()
    {
        return $this->hasMany(Application::class, 'candidate_user_id');
    }

    /**
     * Get the candidate's interviews.
     */
    public function interviews()
    {
        return $this->hasMany(Interview::class, 'user_id');
    }

    /**
     * Get the candidate's availability windows.
     */
    public function availabilityWindows()
    {
        return $this->hasMany(AvailabilityWindow::class, 'candidate_user_id');
    }

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
        ];
    }
}
