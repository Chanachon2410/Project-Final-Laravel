<?php

namespace App\Repositories;

use App\Models\Registration;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface RegistrationRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * @param int $perPage
     * @param array $columns
     * @param array $relations
     * @return LengthAwarePaginator
     */
    public function getPendingRegistrationsPaginated(int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator;
}