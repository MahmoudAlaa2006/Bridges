<?php

namespace App\Repositories;

use App\Models\HRAdmin;

class HRAdminRepository implements Repository
{
    public function find(string $id): ?HRAdmin
    {
        return HRAdmin::find($id);
    }

    public function all()
    {
        return HRAdmin::all();
    }

    public function create(array $data): HRAdmin
    {
        return HRAdmin::create($data);
    }

    public function update(string $id, array $data): HRAdmin
    {
        $admin = $this->find($id);
        $admin->update($data);
        return $admin;
    }

    public function delete(string $id): void
    {
        HRAdmin::destroy($id);
    }
}
