<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use App\Models\AvailabilityWindow;
use App\Models\Interview;
use App\Models\Panel;
use App\Models\Brief;
use App\Models\Slot;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks to allow truncation
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();

        // Truncate tables
        User::truncate();
        Job::truncate();
        Application::truncate();
        AvailabilityWindow::truncate();
        Interview::truncate();
        Panel::truncate();
        Brief::truncate();
        Slot::truncate();

        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 1. Create specialized users for testing
        $this->createSystemUsers();

        // 2. Create Jobs
        $jobs = Job::factory()->count(10)->create();

        // 3. Create HR Employees, Seniors, and Shadows
        $hrEmployees = User::factory()->count(6)->hrEmployee()->create();
        $seniors = User::factory()->count(8)->seniorInterviewer()->create();
        $shadows = User::factory()->count(8)->shadowInterviewer()->create();

        // 4. Create Candidates
        $candidates = User::factory()->count(60)->candidate()->create();

        // 5. Build Applications and Availability
        foreach ($candidates as $index => $candidate) {
            $job = $jobs->random();
            $app = Application::factory()->create([
                'candidate_user_id' => $candidate->id,
                'job_id' => $job->job_id,
            ]);

            // Add 1-7 availability windows
            AvailabilityWindow::factory()
                ->count(fake()->numberBetween(1, 7))
                ->create(['candidate_user_id' => $candidate->id]);

            // For first 15 candidates, generate some interviews
            if ($index < 15) {
                $this->createRealisticInterview($candidate, $app, $seniors, $shadows, $hrEmployees);
            }
        }

        // 6. Test Workload Strategy: Overload the first senior
        $overloadedSenior = $seniors->first();
        for ($i = 0; $i < 9; $i++) {
            $this->createRealisticInterview($candidates->random(), Application::all()->random(), collect([$overloadedSenior]), $shadows, $hrEmployees);
        }

        // 7. SPECIFIC TEST CASE: 12:29 AM today
        $this->createSpecificTestInterview($seniors, $shadows, $hrEmployees, $jobs);
    }

    private function createSpecificTestInterview($seniors, $shadows, $hrEmployees, $jobs)
    {
        $candidate = User::factory()->candidate()->create([
            'email' => 'egypt_candidate@example.com',
            'name' => 'Egypt Midnight Tester',
        ]);

        $job = $jobs->random();
        $app = Application::factory()->create([
            'candidate_user_id' => $candidate->id,
            'job_id' => $job->job_id,
        ]);

        // 12:57 AM Today (May 12, 2026)
        // Local time in metadata is 00:52 +03:00
        $date = \Carbon\Carbon::create(2026, 5, 12, 0, 57, 0);
        
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
            'content' => 'Urgent Egypt Midnight Assessment',
            'presentation_notes' => 'Testing session access at exactly 12:57 AM Egypt Time.',
            'get_date' => $date,
            'status' => Interview::STATUS_SCHEDULED,
        ]);

        $slot->update(['interview_id' => $interview->id]);

        // Panel: Assign 'interviewer@careerportal.com' and an HR employee
        $testInterviewer = User::where('email', 'interviewer@careerportal.com')->first();
        Panel::create(['interview_id' => $interview->id, 'user_id' => $testInterviewer->id ?? $seniors->random()->id]);
        Panel::create(['interview_id' => $interview->id, 'user_id' => $hrEmployees->random()->id]);

        Brief::factory()->create(['interview_id' => $interview->id, 'content' => 'Midnight test brief for Egypt timezone.']);
    }

    private function createSystemUsers()
    {
        User::updateOrCreate(['email' => 'admin@careerportal.com'], [
            'name' => 'System Admin',
            'first_name' => 'System',
            'last_name' => 'Admin',
            'password' => Hash::make('password'),
            'role' => 'HR admin',
        ]);

        User::updateOrCreate(['email' => 'interviewer@careerportal.com'], [
            'name' => 'Senior Interviewer',
            'first_name' => 'Senior',
            'last_name' => 'Interviewer',
            'password' => Hash::make('password'),
            'role' => 'interviewer',
            'interviewer_type' => 'senior',
        ]);
        
        User::updateOrCreate(['email' => 'candidate@careerportal.com'], [
            'name' => 'Sample Candidate',
            'first_name' => 'Sample',
            'last_name' => 'Candidate',
            'password' => Hash::make('password'),
            'role' => 'candidate',
        ]);
    }

    private function createRealisticInterview($candidate, $app, $seniors, $shadows, $hrEmployees)
    {
        $status = fake()->randomElement([
            Interview::STATUS_SCHEDULED,
            Interview::STATUS_COMPLETED,
            Interview::STATUS_PENDING_FEEDBACK
        ]);

        $date = fake()->dateTimeBetween('-1 week', '+2 weeks');
        
        $slot = Slot::create([
            'date' => $date->format('Y-m-d'),
            'start_time' => $date->format('H:i:s'),
            'end_time' => (clone $date)->modify('+1 hour')->format('H:i:s'),
            'time_zone' => 'UTC',
        ]);

        $interview = Interview::create([
            'user_id' => $candidate->id,
            'application_id' => $app->application_id,
            'slot_id' => $slot->id,
            'content' => 'Interview for ' . ($app->job->title ?? 'Position'),
            'presentation_notes' => 'Candidate has strong skills in ' . fake()->word(),
            'get_date' => $date,
            'status' => $status,
        ]);

        $slot->update(['interview_id' => $interview->id]);

        // Build Panel
        Panel::create(['interview_id' => $interview->id, 'user_id' => $seniors->random()->id]);
        Panel::create(['interview_id' => $interview->id, 'user_id' => $shadows->random()->id]);
        Panel::create(['interview_id' => $interview->id, 'user_id' => $hrEmployees->random()->id]);

        // Create Brief
        Brief::factory()->create([
            'interview_id' => $interview->id,
            'content' => "Brief for {$candidate->name}. \nFocus on tech skills. \nJob: " . ($app->job->title ?? 'N/A'),
        ]);
    }
}
