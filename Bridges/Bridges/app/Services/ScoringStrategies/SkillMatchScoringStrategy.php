<?php

namespace App\Services\ScoringStrategies;

use App\Contracts\IScoringStrategy;
use App\Models\Candidate;
use App\Models\Job;

class SkillMatchScoringStrategy implements IScoringStrategy
{
    public function calculateScore(string $candidateId, string $jobId): float
    {
        $candidate = Candidate::find($candidateId);
        $job = Job::find($jobId);
        
        if (!$candidate || !$job) {
            return 0.0;
        }
        
        $candidateSkills = $candidate->skills()->pluck('name')->toArray();
        $candidateSkillsLower = array_map('strtolower', $candidateSkills);
        
        $jobKeywords = json_decode($job->keywords, true) ?? [];
        $jobKeywordsLower = array_map('strtolower', $jobKeywords);
        
        if (empty($jobKeywords) || empty($candidateSkills)) {
            return 0.0;
        }
        
        $matches = 0;
        foreach ($jobKeywordsLower as $keyword) {
            if (in_array($keyword, $candidateSkillsLower)) {
                $matches++;
            }
        }
        
        $skillMatchScore = $matches / count($jobKeywords);
        
        $experienceScore = $this->calculateExperienceMatch($candidate, $job);
        
        $finalScore = ($skillMatchScore * 0.7) + ($experienceScore * 0.3);
        
        return min(1.0, max(0.0, $finalScore));
    }
    
    private function calculateExperienceMatch(Candidate $candidate, Job $job): float
    {
        $candidateYears = $candidate->years_experience ?? 0;
        $jobLevel = strtolower($job->level ?? 'mid-level');
        
        $levelRequirements = [
            'junior' => ['min' => 0, 'max' => 3],
            'mid-level' => ['min' => 3, 'max' => 7],
            'senior' => ['min' => 7, 'max' => 100],
        ];
        
        $requirement = $levelRequirements[$jobLevel] ?? ['min' => 0, 'max' => 100];
        
        if ($candidateYears < $requirement['min']) {
            return max(0.3, 1 - (($requirement['min'] - $candidateYears) / 5));
        } elseif ($candidateYears > $requirement['max']) {
            
            return 0.95;
        } else {
           
            return 1.0;
        }
    }
    
    public function getStrategyName(): string
    {
        return 'SkillMatchScoringStrategy';
    }
    
    public function getWeights(): array
    {
        return [
            'skill_match' => 0.7,
            'experience' => 0.3,
        ];
    }
}
