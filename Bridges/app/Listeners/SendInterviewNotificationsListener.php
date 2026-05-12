<?php

namespace App\Listeners;

use App\Events\InterviewCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendInterviewNotificationsListener implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param InterviewCreated $event
     * @return void
     */
    public function handle(InterviewCreated $event)
    {
        $interview = $event->interview;
        $candidate = $interview->user;
        $panel = $interview->panels()->with('user')->get();

        // Notify Candidate
        Log::info("Notification sent to Candidate ({$candidate->email}): Your interview is scheduled for {$interview->get_date}.");

        // Notify Panel Members
        foreach ($panel as $p) {
            Log::info("Notification sent to Panel Member ({$p->user->email}): You are assigned to an interview on {$interview->get_date}.");
        }
    }
}
