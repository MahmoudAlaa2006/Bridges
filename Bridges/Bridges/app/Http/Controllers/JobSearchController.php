<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class JobSearchController extends Controller
{

    public function browse(): View
    {
        $jobs = $this->jobsFromDb();

        $applicationMap = [];
        $candidateUserId = auth()->id();
        $hasActiveApplication = false;

        if ($candidateUserId) {
            $apps = DB::table('applications')
                ->where('candidate_user_id', $candidateUserId)
                ->get(['job_id', 'status']);

            $userStageIsRejected = DB::table('users')->where('id', $candidateUserId)->value('current_stage') === 'rejected';

            if ($apps->isNotEmpty()) {
                $statusByJobId = $apps->pluck('status', 'job_id');

                $hasActiveApplication = !$userStageIsRejected && $apps->contains(function ($app) {
                    return $app->status !== 'rejected';
                });

                $jobRows = DB::table('jobs')
                    ->whereIn('job_id', $statusByJobId->keys()->toArray())
                    ->get(['job_id', 'requirements']);

                foreach ($jobRows as $row) {
                    $reqs   = json_decode($row->requirements ?? '{}', true);
                    $cardId = $reqs['card_id'] ?? null;
                    if ($cardId) {
                        $applicationMap[$cardId] = $statusByJobId[$row->job_id] ?? null;
                    }
                }
            }
        }

        return view('candidate.jobs', compact('jobs', 'applicationMap', 'hasActiveApplication'));
    }

    public function search(Request $request)
    {
        $q        = strtolower(trim((string) $request->query('q', '')));
        $location = strtolower(trim((string) $request->query('location', 'all locations')));
        $level    = strtolower(trim((string) $request->query('level', 'all levels')));

        $jobs = $this->jobsFromDb();

        $filtered = array_values(array_filter($jobs, function (array $job) use ($q, $location, $level) {
            $haystack = strtolower(implode(' ', [
                $job['title']       ?? '',
                $job['department']  ?? '',
                $job['keywords']    ?? '',
                $job['salaryRange'] ?? '',
                $job['location']    ?? '',
                $job['level']       ?? '',
                $job['description'] ?? '',
            ]));

            if ($q !== '' && strpos($haystack, $q) === false) return false;

            if ($location !== '' && $location !== 'all locations') {
                if (strtolower((string) ($job['location'] ?? '')) !== $location) return false;
            }

            if ($level !== '' && $level !== 'all levels') {
                if (strtolower((string) ($job['level'] ?? '')) !== $level) return false;
            }

            return true;
        }));

        return response()->json(['count' => count($filtered), 'jobs' => $filtered]);
    }

    private function jobsFromDb(): array
    {
        $rows = DB::table('jobs')->where('active', 1)->orderBy('job_id')->get();

        return $rows->map(function ($row) {
            $reqs   = json_decode($row->requirements ?? '{}', true) ?: [];
            $skills = $reqs['skills'] ?? [];

            return [
                'jobId'        => $reqs['card_id']  ?? ('job-' . $row->job_id),
                'title'        => $row->title,
                'department'   => $row->department,
                'salaryRange'  => $row->salary_range,
                'status'       => 'New',
                'keywords'     => implode(' ', array_keys($skills)),
                'location'     => $row->location,
                'level'        => $reqs['level']    ?? 'Mid-level',
                'description'  => $row->benefits,
                'skillWeights' => $skills,
                'minScore'     => (int) ($reqs['min_score'] ?? 0),
            ];
        })->toArray();
    }
}
