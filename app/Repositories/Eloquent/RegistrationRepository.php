<?php

namespace App\Repositories\Eloquent;

use App\Models\Registration;
use App\Repositories\RegistrationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RegistrationRepository extends EloquentRepository implements RegistrationRepositoryInterface
{
    /**
     * @var Registration
     */
    protected $model;

    /**
     * RegistrationRepository constructor.
     * @param Registration $model
     */
    public function __construct(Registration $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @param array $relations
     * @return LengthAwarePaginator
     */
    public function getPendingRegistrationsPaginated(int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator
    {
        return $this->model->with($relations)->where('status', 'pending')->paginate($perPage, $columns);
    }
}