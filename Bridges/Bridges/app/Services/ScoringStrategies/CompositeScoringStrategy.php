<?php

namespace App\Services\ScoringStrategies;

use App\Contracts\IScoringStrategy;

class CompositeScoringStrategy implements IScoringStrategy
{
    private array $strategies = [];
    private array $weights = [];

    public function calculateScore(string $candidateId, string $jobId): float
    {
        $totalScore = 0.0;
        $totalWeight = 0.0;

        foreach ($this->strategies as $strategy) {
            $strategyName = $strategy->getStrategyName();
            $weight = $this->weights[$strategyName] ?? 0;
            $score = $strategy->calculateScore($candidateId, $jobId);
            
            $totalScore += $score * $weight;
            $totalWeight += $weight;
        }

        return $totalWeight > 0 ? $totalScore / $totalWeight : 0.0;
    }

    public function getStrategyName(): string
    {
        return 'CompositeScoringStrategy';
    }

    public function getWeights(): array
    {
        return $this->weights;
    }

    public function addStrategy(IScoringStrategy $strategy, float $weight): void
    {
        $strategyName = $strategy->getStrategyName();
        $this->strategies[$strategyName] = $strategy;
        $this->weights[$strategyName] = $weight;
    }
}
