<?php

namespace App\Services;

use App\Models\Interview;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Support\Facades\Log;

/**
 * Service to manage interview feedback submission and completion logic.
 */
class FeedbackService
{
    /**
     * Submit feedback for an interview.
     *
     * @param User $user
     * @param Interview $interview
     * @param array $data
     * @return Feedback
     */
    public function submitFeedback(User $user, Interview $interview, array $data): Feedback
    {
        $role = strtolower($user->role);
        
        $feedback = Feedback::updateOrCreate(
            [
                'interview_id' => $interview->id,
                'user_id' => $user->id,
            ],
            [
                'role' => $role,
                'score' => $data['score'],
                'feedback_text' => $data['feedback_text'],
                'is_escalated' => $data['is_escalated'] ?? false,
                'escalation_reason' => $data['escalation_reason'] ?? null,
                'submitted_at' => now(),
            ]
        );

        // Check for escalation
        if ($feedback->is_escalated) {
            $this->notifyEscalation($feedback);
        }

        // Check if interview is now fully completed
        $this->checkCompletion($interview);

        return $feedback;
    }

    /**
     * Determine if an interview is fully completed.
     * 
     * Rules: Both the assigned Interviewer AND assigned HR Employee must have submitted feedback.
     *
     * @param Interview $interview
     * @return void
     */
    protected function checkCompletion(Interview $interview)
    {
        $interview->refresh();
        $feedbacks = $interview->feedbacks;
        
        $interviewerFeedback = $feedbacks->where('role', 'interviewer')->first();
        $hrFeedback = $feedbacks->where('role', 'hr employee')->first();

        if ($interviewerFeedback && $hrFeedback) {
            $interview->update(['status' => Interview::STATUS_COMPLETED]);
            Log::info("Interview #{$interview->id} marked as fully completed.");
        }
    }

    /**
     * Simulate escalation notification for HR Admins.
     *
     * @param Feedback $feedback
     * @return void
     */
    protected function notifyEscalation(Feedback $feedback)
    {
        Log::warning("ESCALATION: Interview #{$feedback->interview_id} has been escalated by {$feedback->role} #{$feedback->user_id}. Reason: {$feedback->escalation_reason}");
        // In a real app, this would dispatch a real-time notification or email.
    }
}