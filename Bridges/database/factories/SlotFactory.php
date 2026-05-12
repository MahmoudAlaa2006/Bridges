<?php

namespace Database\Factories;

use App\Models\Slot;
use Illuminate\Database\Eloquent\Factories\Factory;

class SlotFactory extends Factory
{
    protected $model = Slot::class;

    public function definition(): array
    {
        $startHour = fake()->numberBetween(8, 17);
        
        return [
            'interview_id' => null, // Typically set during interview creation
            'date' => fake()->dateTimeBetween('now', '+2 weeks')->format('Y-m-d'),
            'start_time' => sprintf('%02d:00:00', $startHour),
            'end_time' => sprintf('%02d:00:00', $startHour + 1),
            'time_zone' => 'UTC',
        ];
    }
}
