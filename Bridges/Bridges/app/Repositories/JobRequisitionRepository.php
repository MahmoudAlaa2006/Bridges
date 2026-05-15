<?php

namespace App\Repositories;

use App\Models\JobRequisition;

class JobRequisitionRepository implements Repository
{
    public function find(string $id): ?JobRequisition
    {
        return JobRequisition::find($id);
    }

    public function all()
    {
        return JobRequisition::all();
    }

    public function create(array $data): JobRequisition
    {
        return JobRequisition::create($data);
    }

    public function update(string $id, array $data): JobRequisition
    {
        $requisition = $this->find($id);
        $requisition->update($data);
        return $requisition;
    }

    public function delete(string $id): void
    {
        JobRequisition::destroy($id);
    }
}
