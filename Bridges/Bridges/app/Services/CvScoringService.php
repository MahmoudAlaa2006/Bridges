<?php

namespace App\Services;

class CvScoringService
{
    
    public const PROFICIENCY_MAP = [
        'expert'       => 1.00,
        'intermediate' => 0.75,
        'beginner'     => 0.50,
        'none'         => 0.00,
    ];

    public function score(array $skillWeights, array $candidateSkills): float
    {
        if (empty($skillWeights)) {
            return 0.0;
        }

        $totalWeight = array_sum($skillWeights);
        if ($totalWeight <= 0) {
            return 0.0;
        }

        $rawScore = 0.0;

        foreach ($skillWeights as $skill => $weight) {
            $proficiency = $this->resolveProficiency($candidateSkills[$skill] ?? 0.0);
            $rawScore += $weight * $proficiency;
        }

        return round(($rawScore / $totalWeight) * 100, 1);
    }

    private function resolveProficiency(mixed $value): float
    {
        if (is_numeric($value)) {
            return max(0.0, min(1.0, (float) $value));
        }

        $label = strtolower(trim((string) $value));
        return self::PROFICIENCY_MAP[$label] ?? 0.0;
    }

    public static function gradeLabel(float $score): string
    {
        return match(true) {
            $score >= 90 => 'Excellent',
            $score >= 75 => 'Strong',
            $score >= 60 => 'Good',
            $score >= 40 => 'Fair',
            default      => 'Weak',
        };
    }

    public static function gradeColor(float $score): string
    {
        return match(true) {
            $score >= 90 => '#4ade80',   // green
            $score >= 75 => '#a3e635',   // lime
            $score >= 60 => '#facc15',   // yellow
            $score >= 40 => '#fb923c',   // orange
            default      => '#f87171',   // red
        };
    }
}
