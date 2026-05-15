<?php

namespace App\Services;

use App\Models\Interview;
use App\Models\InterviewSession;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * Service to manage interview sessions, access control, and state transitions.
 */
class InterviewSessionService
{
    /**
     * Check if a user can access the session for a specific interview.
     *
     * @param User $user
     * @param Interview $interview
     * @return array ['allowed' => bool, 'message' => string]
     */
    public function canAccessSession(User $user, Interview $interview): array
    {
        // 1. Authorization: Is user part of the panel or the candidate?
        $isPanelMember = $interview->panels->contains('user_id', $user->id);
        $isCandidate = $interview->user_id === $user->id;

        if (!$isPanelMember && !$isCandidate) {
            return ['allowed' => false, 'message' => 'Unauthorized access to this session.'];
        }

        // 2. Time check: Is current time within the slot?
        // We allow access 5 minutes before and during the slot.
        $now = now();
        $slotDate = \Carbon\Carbon::parse($interview->slot->date)->format('Y-m-d');
        $tz = $interview->slot->time_zone ?? config('app.timezone');
        
        $slotStart = Carbon::parse($slotDate . ' ' . $interview->slot->start_time, $tz);
        $slotEnd = Carbon::parse($slotDate . ' ' . $interview->slot->end_time, $tz);

        // Check for approved extensions
        $extensions = (int) $interview->extensionRequests()->where('status', 'approved')->sum('requested_minutes');
        if ($extensions > 0) {
            $slotEnd->addMinutes($extensions);
        }

        if ($now->lt($slotStart->subMinutes(5))) {
            return ['allowed' => false, 'message' => 'The interview session has not started yet. Please wait until ' . $slotStart->format('h:i A') . '.'];
        }

        if ($now->gt($slotEnd)) {
            return ['allowed' => false, 'message' => 'This interview session has already concluded.'];
        }

        return ['allowed' => true, 'message' => 'Access granted.'];
    }

    /**
     * Start or retrieve an existing session for an interview.
     *
     * @param Interview $interview
     * @return InterviewSession
     */
    public function startSession(Interview $interview): InterviewSession
    {
        return InterviewSession::firstOrCreate(
            ['interview_id' => $interview->id],
            [
                'started_at' => now(),
                'status' => InterviewSession::STATUS_ACTIVE,
            ]
        );
    }

    /**
     * End the active session for an interview.
     *
     * @param Interview $interview
     * @return void
     */
    public function endSession(Interview $interview)
    {
        $session = $interview->session;
        if ($session && $session->status === InterviewSession::STATUS_ACTIVE) {
            $session->update([
                'ended_at' => now(),
                'status' => InterviewSession::STATUS_ENDED,
            ]);

            // Update interview status to pending_feedback
            $interview->update(['status' => Interview::STATUS_PENDING_FEEDBACK]);
        }
    }
}
