<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();

        return [
            'name' => $firstName . ' ' . $lastName,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'candidate',
            'interviewer_type' => null,
            'current_stage' => 'technical_test',
            'age' => fake()->numberBetween(20, 55),
            'resume' => 'resumes/placeholder.pdf',
            'has_capacity' => true,
        ];
    }

    public function candidate(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'candidate',
            'current_stage' => fake()->randomElement(['technical_test', 'interview', 'offer', 'rejected']),
        ]);
    }

    public function seniorInterviewer(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'interviewer',
            'interviewer_type' => 'senior',
        ]);
    }

    public function shadowInterviewer(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'interviewer',
            'interviewer_type' => 'shadow',
        ]);
    }

    public function hrEmployee(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'HR employee',
        ]);
    }

    public function hrAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'HR admin',
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
