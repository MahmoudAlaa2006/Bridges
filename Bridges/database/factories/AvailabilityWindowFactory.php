<?php

namespace Database\Factories;

use App\Models\AvailabilityWindow;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvailabilityWindowFactory extends Factory
{
    protected $model = AvailabilityWindow::class;

    public function definition(): array
    {
        $startHour = fake()->numberBetween(8, 15);
        $endHour = $startHour + fake()->numberBetween(2, 6);

        return [
            'candidate_user_id' => User::factory(),
            'date' => fake()->dateTimeBetween('now', '+2 weeks')->format('Y-m-d'),
            'start_time' => sprintf('%02d:00:00', $startHour),
            'end_time' => sprintf('%02d:00:00', $endHour),
            'time_zone' => fake()->randomElement(['UTC', 'Africa/Cairo', 'Europe/London', 'America/New_York', 'Asia/Dubai']),
        ];
    }
}
