<?php

namespace App\Services;

use App\Models\User;
use App\Models\Interview;
use App\Models\Slot;
use Carbon\Carbon;

/**
 * Service to manage and check user availability for interview slots.
 */
class AvailabilityService
{
    /**
     * Get all senior interviewers who are free during the specified slot.
     */
    public function getAvailableSeniorInterviewers(array $slotData)
    {
        return User::where('role', 'interviewer')
            ->where('interviewer_type', 'senior')
            ->get()
            ->filter(fn($user) => !$this->hasTimeConflict($user, $slotData));
    }

    /**
     * Get all shadow interviewers who are free during the specified slot.
     */
    public function getAvailableShadowInterviewers(array $slotData)
    {
        return User::where('role', 'interviewer')
            ->where('interviewer_type', 'shadow')
            ->get()
            ->filter(fn($user) => !$this->hasTimeConflict($user, $slotData));
    }

    /**
     * Get all HR employees who are free during the specified slot.
     */
    public function getAvailableHREmployees(array $slotData)
    {
        return User::where('role', 'HR employee')
            ->get()
            ->filter(fn($user) => !$this->hasTimeConflict($user, $slotData));
    }

    /**
     * Check if a user has an interview conflict at the given slot time.
     * 
     * @param User $user
     * @param array $slotData Contains 'date', 'start_time', 'end_time'
     * @return bool True if conflict exists
     */
    public function hasTimeConflict(User $user, array $slotData): bool
    {
        $slotDate = Carbon::parse($slotData['date'])->format('Y-m-d');
        $slotStart = Carbon::parse($slotData['start_time'])->format('H:i:s');
        $slotEnd = Carbon::parse($slotData['end_time'])->format('H:i:s');

        // Check if user is part of any panel that overlaps with this slot
        return $user->panels()->whereHas('interview', function ($query) use ($slotDate, $slotStart, $slotEnd) {
            $query->whereDate('get_date', $slotDate)
                  ->where(function ($q) use ($slotStart, $slotEnd) {
                      // Overlap logic: (StartA < EndB) AND (EndA > StartB)
                      // Here we assume 1-hour slots, so exact matches are enough
                      // but range check is safer.
                      $q->whereTime('get_date', '>=', $slotStart)
                        ->whereTime('get_date', '<', $slotEnd);
                  });
        })->exists();
    }
}
