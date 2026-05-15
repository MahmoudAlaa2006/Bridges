<?php

namespace App\Repositories;

use App\Models\TransitionRule;

class TransitionRuleRepository implements Repository
{
    public function find(string $id): ?TransitionRule
    {
        return TransitionRule::find($id);
    }

    public function all()
    {
        return TransitionRule::all();
    }

    public function create(array $data): TransitionRule
    {
        return TransitionRule::create($data);
    }

    public function update(string $id, array $data): TransitionRule
    {
        $rule = $this->find($id);
        $rule->update($data);
        return $rule;
    }

    public function delete(string $id): void
    {
        TransitionRule::destroy($id);
    }

    public function findByJobId(string $jobId): array
    {
        return TransitionRule::where('job_id', $jobId)->get()->toArray();
    }
}
