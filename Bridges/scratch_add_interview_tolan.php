<?php

use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use App\Models\Slot;
use App\Models\Interview;
use App\Models\Panel;
use App\Models\Brief;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$email = 'tnolan@example.org';

// 1. Ensure Interviewer exists
$interviewer = User::firstOrCreate(
    ['email' => $email],
    [
        'name' => 'Tolan Tester',
        'first_name' => 'Tolan',
        'last_name' => 'Tester',
        'password' => Hash::make('password'),
        'role' => 'interviewer',
        'interviewer_type' => 'senior'
    ]
);

// 2. Create candidate
$candidate = User::factory()->candidate()->create([
    'name' => 'One Thirty AM Candidate',
    'email' => 'onethirty@example.com'
]);

// 3. Get job
$job = Job::first() ?: Job::factory()->create();

$app = Application::create([
    'candidate_user_id' => $candidate->id,
    'job_id' => $job->job_id,
    'status' => 'interviewing'
]);

// 4. Create 1:30 AM Slot (May 12, 2026)
$date = Carbon::create(2026, 5, 12, 1, 30, 0);

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
    'content' => 'One Thirty AM Assessment for Tolan',
    'presentation_notes' => 'Testing session access at exactly 1:30 AM.',
    'get_date' => $date,
    'status' => Interview::STATUS_SCHEDULED,
]);

$slot->update(['interview_id' => $interview->id]);

Panel::create(['interview_id' => $interview->id, 'user_id' => $interviewer->id]);

Brief::create([
    'interview_id' => $interview->id,
    'content' => "Problem: Reverse a Linked List\n\nGiven the head of a singly linked list, reverse the list, and return the reversed list."
]);

echo "Success: Interview for $email created at 1:30 AM.\n";
