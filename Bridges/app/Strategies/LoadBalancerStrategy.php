<?php

namespace App\Strategies;

/**
 * Strategy interface for selecting the best user from a list.
 */
interface LoadBalancerStrategy
{
    /**
     * Select the best user from the given array of users.
     *
     * @param array $users
     * @return \App\Models\User|null
     */
    public function selectBest(array $users);
}
