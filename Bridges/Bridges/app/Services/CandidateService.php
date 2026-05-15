<?php

namespace App\Services;

use App\Models\Candidate;

class CandidateService
{
    public function __construct(
        private CandidateRepository $candidateRepository
    ) {
    }

    public function updateSkills(string $candidateId, array $skills): void
    {
        $candidate = $this->candidateRepository->find($candidateId);
        
        $skillIds = array_map(fn($skill) => $skill['skill_id'] ?? null, $skills);
        $candidate->skills()->sync(array_filter($skillIds));
    }

    public function updateProfile(string $candidateId, array $profile): void
    {
        $candidate = $this->candidateRepository->find($candidateId);
        $candidate->update($profile);
    }

    public function getCandidateApplications(string $candidateId): array
    {
        $candidate = $this->candidateRepository->find($candidateId);
        return $candidate->applications()->get()->toArray();
    }

    public function calculateExperienceLevel(string $candidateId): string
    {
        $candidate = $this->candidateRepository->find($candidateId);
        $yearsExperience = $candidate->years_experience ?? 0;

        return match (true) {
            $yearsExperience < 1 => 'Entry Level',
            $yearsExperience < 3 => 'Junior',
            $yearsExperience < 5 => 'Mid-Level',
            $yearsExperience < 10 => 'Senior',
            default => 'Lead/Principal',
        };
    }
}
