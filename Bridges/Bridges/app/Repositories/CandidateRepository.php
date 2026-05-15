<?php

namespace App\Repositories;

use App\Models\Candidate;

class CandidateRepository implements Repository
{
    public function find(string $id): ?Candidate
    {
        return Candidate::find($id);
    }

    public function all()
    {
        return Candidate::all();
    }

    public function create(array $data): Candidate
    {
        return Candidate::create($data);
    }

    public function update(string $id, array $data): Candidate
    {
        $candidate = $this->find($id);
        $candidate->update($data);
        return $candidate;
    }

    public function delete(string $id): void
    {
        Candidate::destroy($id);
    }

    public function findByEmail(string $email): ?Candidate
    {
        return Candidate::where('email', $email)->first();
    }
}
