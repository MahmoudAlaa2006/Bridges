<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Application;

class InterviewReadyCandidateSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        
        // 1. Create the Candidate User
        $userId = DB::table('users')->insertGetId([
            'first_name'    => 'Sarah',
            'last_name'     => 'Miller',
            'age'           => 31,
            'email'         => 'sarah.miller@demo.com',
            'password'      => bcrypt('password123'),
            'role'          => 'candidate',
            'current_stage' => 'interview',
            'email_verified_at' => $now,
            'resume'        => 'cvs/sample-cv.pdf',
            'created_at'    => $now,
            'updated_at'    => $now,
        ]);

        // 2. Find a Job to link to
        $job = DB::table('jobs')->first();
        $jobId = $job ? $job->job_id : 1;

        // 3. Create the Application
        DB::table('applications')->insert([
            'candidate_user_id' => $userId,
            'job_id'            => $jobId,
            'status'            => 'applied',
            'match_score'       => 85.5,
            'shortlisted'       => 1,
            'created_at'        => $now,
            'updated_at'        => $now,
        ]);

        // 4. Add Availability Windows
        $windows = [
            [
                'candidate_user_id' => $userId,
                'date'              => $now->addDays(2)->format('Y-m-d'),
                'start_time'        => '09:00',
                'end_time'          => '11:00',
                'time_zone'         => 'UTC',
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'candidate_user_id' => $userId,
                'date'              => $now->addDays(3)->format('Y-m-d'),
                'start_time'        => '14:00',
                'end_time'          => '16:00',
                'time_zone'         => 'UTC',
                'created_at'        => $now,
                'updated_at'        => $now,
            ]
        ];

        DB::table('availability_windows')->insert($windows);

        echo "\n✅ Interview-ready candidate 'Sarah Miller' created (ID: $userId).\n";
        echo "🔗 Demo login: http://127.0.0.1:8000/demo-login?id=$userId\n\n";
    }
}
