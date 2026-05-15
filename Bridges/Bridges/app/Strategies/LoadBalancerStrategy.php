<?php

namespace App\Strategies;

use App\Models\User;
use Illuminate\Support\Collection;

interface LoadBalancerStrategy
{
    public function selectInterviewer(Collection $candidates, string $type): ?User;
}
