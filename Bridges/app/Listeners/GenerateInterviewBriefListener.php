<?php

namespace App\Listeners;

use App\Events\InterviewCreated;
use App\Services\InterviewBriefingService;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateInterviewBriefListener implements ShouldQueue
{
    protected $briefingService;

    public function __construct(InterviewBriefingService $briefingService)
    {
        $this->briefingService = $briefingService;
    }

    /**
     * Handle the event.
     *
     * @param InterviewCreated $event
     * @return void
     */
    public function handle(InterviewCreated $event)
    {
        $this->briefingService->generateBrief($event->interview);
    }
}
