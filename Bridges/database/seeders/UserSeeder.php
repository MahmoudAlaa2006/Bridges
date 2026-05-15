<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Create a test Candidate user.
         */
        User::updateOrCreate(
            ['email' => 'candidate@example.com'],
            [
                'first_name' => 'John',
                'last_name'  => 'Candidate',
                'password'   => Hash::make('password'),
                'role'       => 'candidate',
                'age'        => 25,
            ]
        );

        /**
         * Create a test HR Admin user.
         */
        User::updateOrCreate(
            ['email' => 'hr@example.com'],
            [
                'first_name' => 'Sarah',
                'last_name'  => 'HR',
                'password'   => Hash::make('password'),
                'role'       => 'HR admin',
                'age'        => 35,
            ]
        );
    }
}

