<?php

namespace App\Services;

use App\Models\ShortList;

class RankingService
{
    public function __construct(
        private ApplicationRepository $applicationRepository,
        private ApplicationScoringService $scoringService
    ) {
    }

    public function computeRankings(string $shortlistId): void
    {
        $shortlist = ShortList::find($shortlistId);
        
        if (!$shortlist) {
            throw new \Exception("Shortlist not found");
        }

        if ($shortlist->is_frozen) {
            throw new \Exception("Cannot recompute rankings on frozen shortlist");
        }

        $this->updateRankings($shortlist);
    }

    public function recomputeRankings(string $shortlistId): void
    {
        $shortlist = ShortList::find($shortlistId);
        
        if (!$shortlist) {
            throw new \Exception("Shortlist not found");
        }

        $this->updateRankings($shortlist);
    }

    public function getRankingCriteria(string $jobId): array
    {

        return [
            'match_score' => 0.4,
            'experience_level' => 0.3,
            'skill_match' => 0.2,
            'education' => 0.1,
        ];
    }

    public function getRankExplanation(string $applicationId): array
    {
        $application = $this->applicationRepository->find($applicationId);

        return [
            'application_id' => $application->application_id,
            'candidate_name' => $application->candidate->name,
            'match_score' => $application->match_score,
            'criteria_breakdown' => [
                'match_score' => $application->match_score * 0.4,
                'experience_level' => $this->getExperienceLevelScore($application) * 0.3,
                'skill_match' => $this->getSkillMatchScore($application) * 0.2,
                'education' => $this->getEducationScore($application) * 0.1,
            ],
        ];
    }

    private function updateRankings(ShortList $shortlist): void
    {
        $applications = $shortlist->rankedApplications;
        
        $ranked = $applications->sortByDesc('match_score');
        
        $rank = 1;
        foreach ($ranked as $app) {
            $shortlist->rankedApplications()->updateExistingPivot(
                $app->application_id,
                ['rank' => $rank++]
            );
        }
    }

    private function getExperienceLevelScore(mixed $application): float
    {
        $yearsExperience = $application->candidate->years_experience ?? 0;
        return min($yearsExperience / 20, 1.0);
    }

    private function getSkillMatchScore(mixed $application): float
    {
        $candidateSkills = $application->candidate->skills->pluck('name')->toArray();
        $jobKeywords = $application->job->keywords ?? [];

        $matches = array_intersect($candidateSkills, $jobKeywords);
        return empty($jobKeywords) ? 0 : count($matches) / count($jobKeywords);
    }

    private function getEducationScore(mixed $application): float
    {

        return 0.5;
    }
}
