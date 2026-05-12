<?php

namespace App\Strategies;

use App\Models\User;
use App\Models\Interview;

/**
 * Implementation of LoadBalancerStrategy that selects the user with the lowest current workload.
 */
class LowestWorkloadStrategy implements LoadBalancerStrategy
{
    /**
     * Select the user with the lowest number of scheduled interviews.
     *
     * @param array $users Array of User models or IDs
     * @return User|null
     */
    public function selectBest(array $users)
    {
        if (empty($users)) {
            return null;
        }

        $bestUser = null;
        $lowestWorkload = PHP_INT_MAX;

        foreach ($users as $user) {
            if (!$user instanceof User) {
                $user = User::find($user);
            }

            if (!$user) continue;

            // Workload is the number of interviews currently scheduled or in progress
            $workload = $user->panels()
                ->whereHas('interview', function ($query) {
                    $query->whereIn('status', [
                        Interview::STATUS_SCHEDULED,
                        Interview::STATUS_PENDING_FEEDBACK
                    ]);
                })->count();

            // Constraint: workload <= 9 interviews
            if ($workload >= 9) {
                continue;
            }

            if ($workload < $lowestWorkload) {
                $lowestWorkload = $workload;
                $bestUser = $user;
            }
        }

        return $bestUser;
    }
}
