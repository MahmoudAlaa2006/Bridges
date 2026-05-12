<?php

use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use App\Models\Slot;
use App\Models\Interview;
use App\Models\Panel;
use App\Models\Brief;
use Illuminate\Support\Facades\Hash;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// 1. Ensure Interviewer exists
$interviewer = User::firstOrCreate(
    ['email' => 'aditya52@example.net'],
    [
        'name' => 'Aditya Tester',
        'first_name' => 'Aditya',
        'last_name' => 'Tester',
        'password' => Hash::make('password'),
        'role' => 'interviewer',
        'interviewer_type' => 'senior'
    ]
);

// 2. Create a test candidate
$candidate = User::factory()->candidate()->create([
    'name' => 'One AM Candidate',
    'email' => 'oneam@example.com'
]);

// 3. Get or create a job
$job = Job::first() ?: Job::factory()->create();

$app = Application::create([
    'candidate_user_id' => $candidate->id,
    'job_id' => $job->job_id,
    'status' => 'interviewing'
]);

// 4. Create the 1:00 AM Slot (May 12, 2026)
$date = now()->setTime(1, 0, 0);

$slot = Slot::create([
    'date' => $date->format('Y-m-d'),
    'start_time' => $date->format('H:i:s'),
    'end_time' => (clone $date)->modify('+1 hour')->format('H:i:s'),
    'time_zone' => 'Africa/Cairo',
]);

$interview = Interview::create([
    'user_id' => $candidate->id,
    'application_id' => $app->application_id,
    'slot_id' => $slot->id,
    'content' => 'One AM Critical Assessment',
    'presentation_notes' => 'Testing session access at exactly 1:00 AM.',
    'get_date' => $date,
    'status' => Interview::STATUS_SCHEDULED,
]);

$slot->update(['interview_id' => $interview->id]);

// 5. Assign to Panel
Panel::create(['interview_id' => $interview->id, 'user_id' => $interviewer->id]);

// 6. Create Brief
Brief::create([
    'interview_id' => $interview->id,
    'content' => 'Brief for 1 AM interview.'
]);

echo "Success: Interview for {$interviewer->email} created at 1:00 AM.\n";
