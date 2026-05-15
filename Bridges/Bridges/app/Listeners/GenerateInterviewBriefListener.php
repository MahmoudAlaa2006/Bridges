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

    public function handle(InterviewCreated $event): void
    {
        $this->briefingService->generateBrief($event->interview);
    }
}
