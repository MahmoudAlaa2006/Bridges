<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\User;
use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    public function definition(): array
    {
        return [
            'candidate_user_id' => User::factory(),
            'job_id' => Job::factory(),
            'status' => fake()->randomElement(['applied', 'screening', 'interviewing', 'offered', 'rejected']),
            'match_score' => fake()->numberBetween(60, 98),
            'shortlisted' => fake()->boolean(40),
        ];
    }
}
