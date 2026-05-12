<?php

namespace App\Services;

use App\Strategies\LoadBalancerStrategy;
use App\Models\User;

/**
 * Service to build a valid interview panel consisting of a Senior Interviewer, 
 * a Shadow Interviewer, and an HR Employee.
 */
class PanelBuilderService
{
    protected $availabilityService;
    protected $strategy;

    public function __construct(AvailabilityService $availabilityService, LoadBalancerStrategy $strategy)
    {
        $this->availabilityService = $availabilityService;
        $this->strategy = $strategy;
    }

    /**
     * Build a valid panel for a given slot.
     *
     * @param array $slotData
     * @return array|null Array of User models [senior, shadow, hr] or null if panel cannot be built
     */
    public function buildPanel(array $slotData): ?array
    {
        // 1. Get available candidates for each role
        $seniors = $this->availabilityService->getAvailableSeniorInterviewers($slotData)->toArray();
        $shadows = $this->availabilityService->getAvailableShadowInterviewers($slotData)->toArray();
        $hrs = $this->availabilityService->getAvailableHREmployees($slotData)->toArray();

        // 2. Select best candidate for each role using the strategy
        $selectedSenior = $this->strategy->selectBest($seniors);
        $selectedShadow = $this->strategy->selectBest($shadows);
        $selectedHR = $this->strategy->selectBest($hrs);

        // 3. Validate panel completion
        if (!$selectedSenior || !$selectedShadow || !$selectedHR) {
            return null;
        }

        return [
            'senior' => $selectedSenior,
            'shadow' => $selectedShadow,
            'hr' => $selectedHR,
        ];
    }
}
