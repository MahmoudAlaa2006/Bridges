<?php

namespace App\Repositories;

interface Repository
{
    public function find(string $id);

    public function all();

    public function create(array $data);

    public function update(string $id, array $data);

    public function delete(string $id);
}
