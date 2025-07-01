<?php

namespace App\Contracts\Services;

use App\Models\BaseModel;
use App\Models\Habits\Habit;
use Illuminate\Support\Collection;

interface EntityServiceInterface
{
    public function getAll(int $userId): Collection;
    public function getById(int $habitId, int $userId): ?BaseModel;

    public function create(array $data): ?BaseModel;

    public function update(int $habitId, array $data): ?BaseModel;
    public function delete(int $habitId, int $userId): bool;

}
