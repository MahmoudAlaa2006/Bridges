<?php

namespace App\Factories;

use App\Models\Interview;
use App\Models\User;
use App\Models\Slot;
use App\Models\Application;

class InterviewFactory
{
    public function createFromAvailability(Application $application, Slot $slot, array $panelUsers): Interview
    {
        $interview = Interview::create([
            'user_id' => $application->candidate_user_id,
            'slot_id' => $slot->id,
            'get_date' => $slot->start_time,
            'is_finish' => false,
        ]);

        foreach ($panelUsers as $user) {
            $interview->panels()->create([
                'user_id' => $user->id,
                'role' => $user->interviewer_type ?? 'Interviewer',
            ]);
        }

        return $interview;
    }
}