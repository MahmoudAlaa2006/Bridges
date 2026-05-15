<?php

namespace App\Repositories;

use App\Models\Application;

class ApplicationRepository implements Repository
{
    public function find(string $id): ?Application
    {
        return Application::find($id);
    }

    public function all()
    {
        return Application::all();
    }

    public function create(array $data): Application
    {
        return Application::create($data);
    }

    public function update(string $id, array $data): Application
    {
        $application = $this->find($id);
        $application->update($data);
        return $application;
    }

    public function delete(string $id): void
    {
        Application::destroy($id);
    }

    public function findByCandidateAndJob(string $candidateId, string $jobId): array
    {
        return Application::where('candidate_id', $candidateId)
            ->where('job_id', $jobId)
            ->get()
            ->toArray();
    }

    public function findDuplicatesOf(string $applicationId): array
    {
        return Application::where('duplicate_of', $applicationId)
            ->get()
            ->toArray();
    }
}
