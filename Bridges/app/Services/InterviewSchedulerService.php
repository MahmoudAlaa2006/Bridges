<?php

namespace App\Services;

use App\Models\User;
use App\Models\Slot;
use App\Factories\InterviewFactory;
use App\Events\InterviewCreated;
use Illuminate\Support\Collection;

/**
 * Main orchestration service for scheduling interviews based on candidate availability.
 */
class InterviewSchedulerService
{
    protected $slotGenerator;
    protected $panelBuilder;

    public function __construct(TimeSlotGeneratorService $slotGenerator, PanelBuilderService $panelBuilder)
    {
        $this->slotGenerator = $slotGenerator;
        $this->panelBuilder = $panelBuilder;
    }

    /**
     * Orchestrate the scheduling process for a candidate.
     *
     * @param User $candidate
     * @param int|null $applicationId
     * @return \App\Models\Interview|null
     */
    public function schedule(User $candidate, $applicationId = null)
    {
        // 1. Get candidate availability windows
        $windows = $candidate->availabilityWindows;
        if ($windows->isEmpty()) {
            return null;
        }

        // 2. Generate UTC slots
        $slots = $this->slotGenerator->generateSlots($windows);

        // 3. Iterate through slots and attempt to build a panel
        foreach ($slots as $slotData) {
            $panel = $this->panelBuilder->buildPanel($slotData);

            if ($panel) {
                // 4. Panel found! Persist the slot and create the interview
                $persistedSlot = Slot::create($slotData);
                
                $interview = InterviewFactory::create(
                    $candidate,
                    $persistedSlot,
                    $panel,
                    $applicationId
                );

                // 5. Dispatch Event
                event(new InterviewCreated($interview));

                // 6. Stop scheduling (Stop when valid slot found)
                return $interview;
            }
        }

        return null; // No valid slot found
    }
}
