<?php

namespace App\Services;

use App\Contracts\IScoringStrategy;
use App\Models\Application;
use App\Models\Candidate;

class ApplicationScoringService
{
    
    private ?IScoringStrategy $scoringStrategy = null;

    public function __construct(
        private ApplicationRepository $applicationRepository,
        private CandidateRepository $candidateRepository
    ) {
    }

    public function setScoringStrategy(IScoringStrategy $strategy): void
    {
        $this->scoringStrategy = $strategy;
    }

    public function calculateMatchScore(string $applicationId): float
    {
        $application = $this->applicationRepository->find($applicationId);

        if (!$this->scoringStrategy) {
            return 0.0;
        }

        $score = $this->scoringStrategy->calculateScore(
            $application->candidate_id,
            $application->job_id
        );

        $application->update(['match_score' => $score]);

        return $score;
    }
}
