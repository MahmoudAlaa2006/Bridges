<?php

namespace App\Services;

use App\Models\Interview;
use App\Models\InterviewSession;
use App\Models\TimeExtensionRequest;
use App\Models\User;
use Carbon\Carbon;

class InterviewSessionService
{
    public function canAccess(Interview $interview, User $user): bool
    {
        // Candidate and Panel can access
        $isPanel = $interview->panels()->where('user_id', $user->id)->exists();
        $isCandidate = $interview->user_id === $user->id;

        if (!$isPanel && !$isCandidate) return false;

        // Check if session is within time window (e.g., 5 mins before start)
        $startTime = Carbon::parse($interview->slot->start_time);
        return now()->addMinutes(5)->greaterThanOrEqualTo($startTime);
    }

    public function getOrCreateSession(Interview $interview): InterviewSession
    {
        return InterviewSession::firstOrCreate(
            ['interview_id' => $interview->id],
            [
                'status' => 'active',
                'started_at' => now(),
                'scheduled_duration' => 60, // default 60 mins
            ]
        );
    }

    public function endSession(Interview $interview): void
    {
        $session = $interview->session;
        if ($session) {
            $session->update([
                'status' => 'completed',
                'ended_at' => now(),
            ]);
        }
    }

    public function requestExtension(Interview $interview, User $user, int $minutes, string $reason): TimeExtensionRequest
    {
        return TimeExtensionRequest::create([
            'interview_id' => $interview->id,
            'requester_id' => $user->id,
            'requested_minutes' => $minutes,
            'reason' => $reason,
            'status' => 'pending',
        ]);
    }
}
