<?php

namespace App\Services;

use App\Models\AvailabilityWindow;
use App\Models\Slot;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Service to generate discrete 60-minute interview slots from availability windows.
 */
class TimeSlotGeneratorService
{
    /**
     * Generate UTC slots from candidate availability windows.
     *
     * @param Collection $windows Collection of AvailabilityWindow models
     * @return Collection Collection of Slot data (not persisted yet or persisted depending on preference)
     */
    public function generateSlots(Collection $windows): Collection
    {
        $generatedSlots = collect();

        foreach ($windows as $window) {
            $timezone = $window->time_zone ?? 'UTC';
            
            // Create Carbon instances for start and end in the local timezone
            $start = Carbon::createFromFormat('Y-m-d H:i:s', $window->date->format('Y-m-d') . ' ' . $window->start_time, $timezone);
            $end = Carbon::createFromFormat('Y-m-d H:i:s', $window->date->format('Y-m-d') . ' ' . $window->end_time, $timezone);

            // Convert to UTC
            $startUtc = $start->copy()->setTimezone('UTC');
            $endUtc = $end->copy()->setTimezone('UTC');

            $current = $startUtc->copy();

            // Generate 60-minute slots
            while ($current->copy()->addHour()->lte($endUtc)) {
                $generatedSlots->push([
                    'date' => $current->copy()->startOfDay(),
                    'start_time' => $current->copy()->format('H:i:s'),
                    'end_time' => $current->copy()->addHour()->format('H:i:s'),
                    'time_zone' => 'UTC',
                ]);
                $current->addHour();
            }
        }

        return $generatedSlots;
    }
}
