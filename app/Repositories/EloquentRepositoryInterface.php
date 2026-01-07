<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface EloquentRepositoryInterface
{
    /**
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection;

    /**
     * @param int $perPage
     * @param array $columns
     * @param array $relations
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator;

    /**
     * @param array $payload
     * @return Model
     */
    public function create(array $payload): ?Model;

    /**
     * @param int $modelId
     * @param array $payload
     * @return Model
     */
    public function update(int $modelId, array $payload): ?Model;

    /**
     * @param int $modelId
     * @return bool
     */
    public function deleteById(int $modelId): bool;

    /**
     * @param int $modelId
     * @param array $columns
     * @param array $relations
     * @return Model
     */
    public function findById(int $modelId, array $columns = ['*'], array $relations = []): ?Model;

    /**
     * @param string $column
     * @param string $value
     * @param array $columns
     * @param array $relations
     * @return Model
     */
    public function findByColumn(string $column, string $value, array $columns = ['*'], array $relations = []): ?Model;
}