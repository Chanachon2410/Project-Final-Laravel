<?php

namespace App\Repositories;

use App\Models\Subject;

interface SubjectRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * @param string $search
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(string $search, int $perPage);
}