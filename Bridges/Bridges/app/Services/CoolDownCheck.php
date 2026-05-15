<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CoolDownCheck
{
    /**
     * Cool-down period in months.
     */
    private const COOLDOWN_MONTHS = 6;

    /**
     * Check whether a candidate is eligible to take an exam for a given job.
     *
     * - First-time candidate → eligible.
     * - Last submission older than 6 months → eligible.
     * - Otherwise → not eligible, returns next eligible date.
     *
     * @param  int  $candidateId
     * @param  int  $jobId
     * @return array{eligible: bool, next_eligible_date?: Carbon, last_submitted_at?: Carbon}
     */
    public function isEligible(int $candidateId, int $jobId): array
    {
        // Find the most recent submitted assessment for this candidate + job
        $lastAssessment = DB::table('assessments')
            ->where('candidate_id', $candidateId)
            ->where('job_id', $jobId)
            ->whereIn('status', ['SUBMITTED', 'GRADED'])
            ->whereNotNull('submitted_at')
            ->orderByDesc('submitted_at')
            ->first();

        // First-time candidate — no previous submission exists
        if (!$lastAssessment) {
            return ['eligible' => true];
        }

        $lastSubmittedAt  = Carbon::parse($lastAssessment->submitted_at);
        $nextEligibleDate = $lastSubmittedAt->copy()->addMonths(self::COOLDOWN_MONTHS);

        // Cool-down has expired — candidate is eligible again
        if (Carbon::now()->gte($nextEligibleDate)) {
            return ['eligible' => true];
        }

        // Still in cool-down — candidate cannot retake
        return [
            'eligible'           => false,
            'next_eligible_date' => $nextEligibleDate,
            'last_submitted_at'  => $lastSubmittedAt,
        ];
    }

    /**
     * Update any PENDING assessments for a candidate+job to COOLDOWN
     * if they are still within the 6-month cool-down window.
     *
     * @param  int  $candidateId
     * @param  int  $jobId
     * @return void
     */
    public function applyCoolDown(int $candidateId, int $jobId): void
    {
        $result = $this->isEligible($candidateId, $jobId);

        if (!$result['eligible']) {
            // Set all PENDING assessments for this candidate+job to COOLDOWN
            DB::table('assessments')
                ->where('candidate_id', $candidateId)
                ->where('job_id', $jobId)
                ->where('status', 'PENDING')
                ->update(['status' => 'COOLDOWN']);
        }
    }
}
