<?php

namespace Database\Factories;

use App\Models\Panel;
use App\Models\Interview;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PanelFactory extends Factory
{
    protected $model = Panel::class;

    public function definition(): array
    {
        return [
            'interview_id' => Interview::factory(),
            'user_id' => User::factory(),
        ];
    }
}
