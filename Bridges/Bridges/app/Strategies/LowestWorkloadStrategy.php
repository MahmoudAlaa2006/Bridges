<?php

namespace App\Strategies;

use App\Models\User;
use Illuminate\Support\Collection;

class LowestWorkloadStrategy implements LoadBalancerStrategy
{
    public function selectInterviewer(Collection $candidates, string $type): ?User
    {
        return $candidates
            ->where('interviewer_type', $type)
            ->where('has_capacity', true)
            ->sortBy(function ($user) {
                return $user->panels()->count();
            })
            ->first();
    }
}
