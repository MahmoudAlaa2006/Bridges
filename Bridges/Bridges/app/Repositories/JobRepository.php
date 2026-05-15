<?php

namespace App\Repositories;

use App\Models\Job;

class JobRepository implements Repository
{
    public function find(string $id): ?Job
    {
        return Job::find($id);
    }

    public function all()
    {
        return Job::all();
    }

    public function create(array $data): Job
    {
        return Job::create($data);
    }

    public function update(string $id, array $data): Job
    {
        $job = $this->find($id);
        $job->update($data);
        return $job;
    }

    public function delete(string $id): void
    {
        Job::destroy($id);
    }

    public function findByStatus(string $status): array
    {
        return Job::where('status', $status)->get()->toArray();
    }

    public function search(array $criteria): array
    {
        $query = Job::query();

        if (isset($criteria['title'])) {
            $query->where('title', 'like', '%' . $criteria['title'] . '%');
        }

        if (isset($criteria['department'])) {
            $query->where('department', $criteria['department']);
        }

        if (isset($criteria['status'])) {
            $query->where('status', $criteria['status']);
        }

        return $query->get()->toArray();
    }
}
