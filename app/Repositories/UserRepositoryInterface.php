<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * @param int $roleId
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function getUsersByRoleId(int $roleId, array $columns = ['*'], array $relations = []): Collection;
}