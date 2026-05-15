<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Offer;
use App\Models\User;
use App\Models\Job;
use App\Services\OfferService;

/**
 * ============================================================================
 * Candidate Dashboard Controller
 * ============================================================================
 */
class CandidateDashboardController extends Controller
{
    public function overview()
    {
        /** @var User $user */
        $user = Auth::user();
        
        $data = [
            'candidate' => $user,
            'candidateName' => $user->name,
            'applications' => $user->applications()->with('job')->get(),
            'upcomingInterviews' => $user->interviews()->where('get_date', '>=', now())->get(),
        ];

        return view('candidate.overview', $data);
    }

    public function jobs()
    {
        /** @var User $user */
        $user = Auth::user();
        
        // Fetch active jobs from DB
        $dbJobs = Job::where('active', true)->get();
        
        $jobs = $dbJobs->map(function ($job) {
            $reqs = json_decode($job->requirements, true) ?: [];

            $skillWeights = [];
            if (isset($reqs['skills']) && is_array($reqs['skills'])) {
                $skillWeights = $reqs['skills'];
            }

            // Standardize jobId: card_id from requirements JSON or fallback to job-ID
            $cardId = $reqs['card_id'] ?? ('job-' . $job->job_id);

            return [
                'jobId'       => $cardId,
                'title'       => $job->title,
                'department'  => $job->department,
                'location'    => $job->location_type ?? $job->location ?? 'Remote',
                'level'       => $reqs['level'] ?? 'Mid-level',
                'salaryRange' => $job->salary_range,
                'description' => $job->description,
                'keywords'    => implode(' ', array_keys($skillWeights)),
                'skillWeights'=> $skillWeights
            ];
        });

        // Get user's applications to show status
        $apps = $user->applications()->get(['job_id', 'status']);
        $applicationMap = [];
        
        if ($apps->isNotEmpty()) {
            $statusByJobId = $apps->pluck('status', 'job_id');
            
            // Map DB job_ids back to their card_id keys for the frontend lookup
            $jobRows = \Illuminate\Support\Facades\DB::table('jobs')
                ->whereIn('job_id', $statusByJobId->keys()->toArray())
                ->get(['job_id', 'requirements']);

            foreach ($jobRows as $row) {
                $reqs   = json_decode($row->requirements ?? '{}', true);
                $cardId = $reqs['card_id'] ?? ('job-' . $row->job_id);
                $applicationMap[$cardId] = $statusByJobId[$row->job_id] ?? null;
            }
        }

        // Check if user has any active application
        $hasActiveApplication = $user->applications()
            ->whereNotIn('status', ['rejected', 'hired'])
            ->exists();

        return view('candidate.jobs', compact('user', 'jobs', 'applicationMap', 'hasActiveApplication'));
    }

    public function interview()
    {
        /** @var User $user */
        $user = Auth::user();
        
        $interviews = $user->interviews()
            ->with(['application.job', 'slot', 'panels.user'])
            ->get();

        $availability = $user->availabilityWindows;

        return view('candidate.interview', compact('user', 'interviews', 'availability'));
    }

    public function exam()
    {
        /** @var User $user */
        $user = Auth::user();
        $currentStage = $user->current_stage;
        $activeApplication = $user->applications()->where('status', '!=', 'rejected')->latest()->with('job')->first();

        return view('candidate.exam', compact('user', 'currentStage', 'activeApplication'));
    }

    public function examTemplate()
    {
        /** @var User $user */
        $user = Auth::user();
        $activeApplication = $user->applications()->where('status', '!=', 'rejected')->latest()->with('job')->first();
        
        $questions = collect();
        if ($activeApplication && $activeApplication->job) {
            $questions = $activeApplication->job->questionBanks()
                ->with(['mcqQuestion', 'writtenQuestion', 'codeQuestion'])
                ->get();
        }

        return view('candidate.exam_template', compact('user', 'activeApplication', 'questions'));
    }

    public function offer()
    {
        $user = Auth::user();
        if ($user->offer_id) {
            $offer = app(OfferService::class)->viewOffer($user->offer_id);
        } else {
            $offer = null;
        }
        $totalCompensation = $offer ? $offer->calculateTotal() : 0;
        return view('candidate.offer', compact('user', 'offer', 'totalCompensation'));
    }

    public function offerAccept(int $id): RedirectResponse
    {
        $offer = Offer::findOrFail($id);
        try {
            app(OfferService::class)->acceptOffer($offer);
            $flash = ['success' => 'Offer accepted successfully.'];
        } catch (\RuntimeException $e) {
            $flash = ['error' => $e->getMessage()];
        }
        return redirect()->route('candidate.offer')->with($flash);
    }

    public function offerReject(int $id): RedirectResponse
    {
        $offer = Offer::findOrFail($id);
        try {
            app(OfferService::class)->rejectOffer($offer);
            $flash = ['info' => 'Offer declined.'];
        } catch (\RuntimeException $e) {
            $flash = ['error' => $e->getMessage()];
        }
        return redirect()->route('candidate.offer')->with($flash);
    }

    public function profile()
    {
        $user = Auth::user();
        return view('candidate.profile', [
            'user' => $user,
            'cvPath' => $user->resume,
            'cvFileName' => $user->resume ? basename($user->resume) : 'My_Resume.pdf',
            'cvUploadedAt' => $user->updated_at ? $user->updated_at->format('M d, Y') : null,
        ]);
    }
}
