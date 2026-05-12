<?php

namespace App\Factories;

use App\Models\Interview;
use App\Models\User;
use App\Models\Slot;
use App\Models\Panel;
use Illuminate\Support\Facades\DB;

/**
 * Factory class to centralize the creation of Interview records and their associated panels.
 */
class InterviewFactory
{
    /**
     * Create a complete interview record.
     *
     * @param User $candidate
     * @param Slot $slot
     * @param array $panelMembers Array of User models
     * @param int|null $applicationId
     * @return Interview
     */
    public static function create(User $candidate, Slot $slot, array $panelMembers, $applicationId = null)
    {
        return DB::transaction(function () use ($candidate, $slot, $panelMembers, $applicationId) {
            // 1. Create the Interview
            $interview = Interview::create([
                'user_id' => $candidate->id,
                'application_id' => $applicationId,
                'slot_id' => $slot->id,
                'get_date' => $slot->date->setTimeFromTimeString($slot->start_time),
                'status' => Interview::STATUS_SCHEDULED,
                'content' => 'Standard Interview',
            ]);

            // 2. Attach Slot to Interview (Circular ref in schema, but we fill both)
            $slot->update(['interview_id' => $interview->id]);

            // 3. Attach Panel Members
            foreach ($panelMembers as $member) {
                Panel::create([
                    'interview_id' => $interview->id,
                    'user_id' => $member->id,
                ]);
            }

            return $interview;
        });
    }
}
