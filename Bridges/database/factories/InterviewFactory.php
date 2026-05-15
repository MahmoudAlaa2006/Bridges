<?php

namespace Database\Factories;

use App\Models\Interview;
use App\Models\User;
use App\Models\Slot;
use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

class InterviewFactory extends Factory
{
    protected $model = Interview::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->candidate(),
            'application_id' => Application::factory(),
            'slot_id' => Slot::factory(),
            'content' => fake()->sentence(),
            'presentation_notes' => fake()->paragraph(),
            'get_date' => fake()->dateTimeBetween('now', '+2 weeks'),
            'status' => fake()->randomElement([
                Interview::STATUS_SCHEDULED,
                Interview::STATUS_COMPLETED,
                Interview::STATUS_PENDING_FEEDBACK
            ]),
        ];
    }

    public function scheduled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Interview::STATUS_SCHEDULED,
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Interview::STATUS_COMPLETED,
        ]);
    }

    public function pendingFeedback(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Interview::STATUS_PENDING_FEEDBACK,
        ]);
    }
}
