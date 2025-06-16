<?php

namespace App\Contracts\Services;

use App\Models\BaseModel;
use Illuminate\Support\Collection;

interface EntityServiceInterface
{
    public function getAll(int $userId): Collection;
    public function getById(int $habitId, int $userId): ?BaseModel;

    public function create(array $data): ?BaseModel;

    public function update(int $id, array $data): bool;
    public function deleteById(int $id): bool;

}
