<?php

namespace Database\Factories;

use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    protected $model = Job::class;

    public function definition(): array
    {
        $titles = [
            'Senior Frontend Developer', 'Backend Architect', 'Full Stack Engineer',
            'Product Manager', 'UX Designer', 'DevOps Specialist',
            'QA Automation Lead', 'Data Scientist', 'HR Specialist',
            'Mobile Developer (iOS/Android)', 'Security Engineer'
        ];

        return [
            'title' => fake()->randomElement($titles),
            'department' => fake()->randomElement(['Engineering', 'Product', 'Design', 'HR', 'Infrastructure']),
            'location' => fake()->city() . ', ' . fake()->country(),
            'salary_range' => '$' . fake()->numberBetween(80, 120) . 'k - $' . fake()->numberBetween(130, 180) . 'k',
            'active' => true,
            'description' => fake()->paragraphs(3, true),
            'benefits' => "Flexible hours, health insurance, remote work options, learning budget.",
            'requirements' => "Strong problem solving skills, experience with modern tech stacks, team player.",
        ];
    }
}
