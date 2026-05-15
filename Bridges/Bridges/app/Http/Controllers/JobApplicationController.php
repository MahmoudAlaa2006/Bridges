<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Notification;
use App\Models\User;
use App\Services\CvScoringService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobApplicationController extends Controller
{
    private const SHORTLIST_TOP_N     = 3;
    private const SHORTLIST_MIN_SCORE = 70.0;

    public function __construct(private readonly CvScoringService $scorer) {}

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'job_id'          => 'required|string|max:64',
            'job_title'       => 'required|string|max:255',
            'company'         => 'required|string|max:255',
            'applicant_name'  => 'required|string|max:200',
            'applicant_email' => 'required|email|max:200',
            'skill_weights'   => 'nullable|string',
            'skills'          => 'nullable|array',
            'skills.*'        => 'required|numeric|min:0.01|max:1',
            'cover_letter'    => 'nullable|string|max:5000',
            'cv'              => 'required|file|mimes:pdf,doc,docx,txt|max:5120',
        ]);

        $dbJobId = $this->findOrCreateJob($validated['job_id'], $validated['job_title'], $validated['company']);

        $existingUser    = User::where('email', $validated['applicant_email'])->first();

        $experienceYears = (int) ($existingUser?->Experience ?? 0);

        if ($existingUser) {
            // Rule 1: Cannot apply for the same job twice (ever)
            $alreadyApplied = Application::where('candidate_user_id', $existingUser->id)
                ->where('job_id', $dbJobId)
                ->exists();
            if ($alreadyApplied) {
                return response()->json([
                    'success' => false,
                    'error'   => 'already_applied',
                    'message' => 'You have already applied for this position previously. Multiple applications for the same role are not permitted.',
                ], 422);
            }

            // Rule 2: Cannot apply for any other job until current is concluded
            $hasActiveApplication = Application::where('candidate_user_id', $existingUser->id)
                ->whereNotIn('status', ['rejected', 'hired'])
                ->exists();

            if ($hasActiveApplication) {
                return response()->json([
                    'success' => false,
                    'error'   => 'active_application',
                    'message' => 'You currently have an active application in progress. You may only apply for a new position after your current application has been rejected or concluded.',
                ], 422);
            }
        }

        if ($request->hasFile('cv')) {
            $originalName = $request->file('cv')->getClientOriginalName();
            $cvExists = User::whereNotNull('resume')
                ->get(['resume'])
                ->contains(fn($u) => basename($u->resume) === $originalName
                                  || str_ends_with($u->resume, '/' . $originalName));
            if ($cvExists) {
                return response()->json([
                    'success' => false,
                    'error'   => 'duplicate_cv',
                    'message' => 'A CV with the filename "' . $originalName . '" already exists in our system. Please rename your file or upload a different document.',
                ], 422);
            }
        }

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs', 'public');
        }

        $skillWeights    = json_decode($validated['skill_weights'] ?? '{}', true) ?: [];
        $candidateSkills = $validated['skills'] ?? [];
        $baseScore       = $this->scorer->score($skillWeights, $candidateSkills);

        $experienceBonus = $experienceYears * 2;
        $matchScore      = min(100.0, $baseScore + $experienceBonus);

        $jobRow   = DB::table('jobs')->where('job_id', $dbJobId)->first();
        $jobReqs  = json_decode($jobRow->requirements ?? '{}', true);
        $minScore = (float) ($jobReqs['min_score'] ?? 0);

        $isRejected = $matchScore < $minScore;
        $appStatus  = $isRejected ? 'rejected' : 'applied';

        $user = auth()->user();
        if ($cvPath) {
            $user->update(['resume' => $cvPath]);
        }

        $application = Application::create([
            'candidate_user_id' => $user->id,
            'job_id'            => $dbJobId,
            'status'            => $appStatus,
            'match_score'       => $matchScore,
        ]);

        if (!$isRejected) {
            $this->updateShortlist($dbJobId);

            $user->update(['current_stage' => 'technical_test']);

            // ── Notify candidate: CV passed ────────────────────────────────
            Notification::create([
                'notification_id' => Str::uuid(),
                'recipient_id'    => $user->id,
                'subject'         => '✅ CV Passed — Take Your Exam',
                'message'         => 'Great news! Your application for "' . $validated['job_title'] . '" has passed CV screening '
                                   . 'with a match score of ' . round($matchScore) . '%. '
                                   . 'Your next step is to complete the technical assessment. '
                                   . 'Head over to the Exams section to get started.',
                'type'            => 'cv_passed',
                'created_at'      => now(),
            ]);
        } else {
            // ── Notify candidate: CV rejected ──────────────────────────────
            Notification::create([
                'notification_id' => Str::uuid(),
                'recipient_id'    => $user->id,
                'subject'         => '❌ Application Unsuccessful',
                'message'         => 'Thank you for applying to "' . $validated['job_title'] . '". '
                                   . 'Unfortunately, your CV score of ' . round($matchScore) . '% did not meet '
                                   . 'the minimum requirement of ' . round($minScore) . '% for this role. '
                                   . 'We encourage you to build on your skills and apply again in the future.',
                'type'            => 'cv_rejected',
                'created_at'      => now(),
            ]);
        }

        $applied = session()->get('applied_jobs', []);
        $applied[$validated['job_id']] = [
            'job_title'   => $validated['job_title'],
            'company'     => $validated['company'],
            'match_score' => $matchScore,
            'applied_at'  => now()->toDateTimeString(),
        ];
        session()->put('applied_jobs', $applied);

        $rank = $this->getApplicationRank($application->application_id, $dbJobId);

        return response()->json([
            'success'           => true,
            'message'           => 'Application submitted for ' . $validated['job_title'],
            'cv_uploaded'       => (bool) $cvPath,
            'base_score'        => $baseScore,
            'experience_bonus'  => $experienceBonus,
            'experience_years'  => $experienceYears,
            'match_score'       => $matchScore,
            'grade_label'       => CvScoringService::gradeLabel($matchScore),
            'grade_color'       => CvScoringService::gradeColor($matchScore),
            'rank'              => $isRejected ? null : $rank,
            'is_shortlisted'    => !$isRejected && $matchScore >= self::SHORTLIST_MIN_SCORE,
            'is_rejected'       => $isRejected,
            'min_score'         => $minScore,
        ]);
    }

    public function applied(): JsonResponse
    {
        return response()->json([
            'applied_job_ids' => array_keys(session()->get('applied_jobs', [])),
        ]);
    }

    private function findOrCreateJob(string $cardJobId, string $title, string $company): int
    {
        // ── 1. Try to find by card_id stored in requirements JSON ──────────
        $row = DB::table('jobs')
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(requirements, '$.card_id')) = ?", [$cardJobId])
            ->first();

        if ($row) {
            return $row->job_id;
        }

        // ── 2. Handle fallback IDs like "job-5" (no card_id in requirements) ──
        //    When a DB job has no card_id, the frontend generates 'job-{db_id}'
        //    as the jobId. Detect this pattern and resolve to the existing row
        //    instead of creating a duplicate.
        if (preg_match('/^job-(\d+)$/', $cardJobId, $m)) {
            $existing = DB::table('jobs')->where('job_id', (int) $m[1])->first();
            if ($existing) {
                // Back-fill card_id so future lookups use the fast JSON path
                $reqs = json_decode($existing->requirements ?? '{}', true) ?: [];
                if (empty($reqs['card_id'])) {
                    $reqs['card_id'] = $cardJobId;
                    DB::table('jobs')->where('job_id', $existing->job_id)
                        ->update(['requirements' => json_encode($reqs), 'updated_at' => now()]);
                }
                return $existing->job_id;
            }
        }

        // ── 3. Truly new job — create it ───────────────────────────────────
        $jobId = DB::table('jobs')->insertGetId([
            'title'        => $title,
            'department'   => $company,
            'active'       => 1,
            'requirements' => json_encode(['card_id' => $cardJobId, 'min_score' => 55, 'skills' => []]),
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        // Auto-seed default questions for the new job
        $seeder = new \Database\Seeders\ExamSeeder();
        $seeder->run($jobId);

        return $jobId;
    }

    private function updateShortlist(int $dbJobId): void
    {
        $apps = Application::where('job_id', $dbJobId)
            ->orderByDesc('match_score')
            ->get();

        foreach ($apps as $rank => $app) {
            $position      = $rank + 1;
            $isShortlisted = ($app->match_score >= self::SHORTLIST_MIN_SCORE)
                          || ($position <= self::SHORTLIST_TOP_N);

            $app->update(['shortlisted' => $isShortlisted ? 1 : 0]);

            $inShortlist = DB::table('shortlists')
                ->where('application_id', $app->application_id)
                ->exists();

            if ($isShortlisted && !$inShortlist) {
                DB::table('shortlists')->insert([
                    'application_id' => $app->application_id,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            } elseif (!$isShortlisted && $inShortlist) {
                DB::table('shortlists')
                    ->where('application_id', $app->application_id)
                    ->delete();
            }
        }
    }

    private function getApplicationRank(int $applicationId, int $dbJobId): int
    {
        $apps = Application::where('job_id', $dbJobId)
            ->orderByDesc('match_score')
            ->pluck('application_id')
            ->toArray();

        $pos = array_search($applicationId, $apps);
        return $pos !== false ? $pos + 1 : 0;
    }
}
