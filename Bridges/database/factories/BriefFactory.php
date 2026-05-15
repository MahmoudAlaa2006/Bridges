<?php

namespace Database\Factories;

use App\Models\Brief;
use App\Models\Interview;
use Illuminate\Database\Eloquent\Factories\Factory;

class BriefFactory extends Factory
{
    protected $model = Brief::class;

    public function definition(): array
    {
        return [
            'interview_id' => Interview::factory(),
            'content' => fake()->text(500),
            'is_read_only' => false,
            'last_updated' => now(),
        ];
    }
}
