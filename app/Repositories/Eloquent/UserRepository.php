<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Collection;

class UserRepository extends EloquentRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    protected $model;

    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $roleId
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function getUsersByRoleId(int $roleId, array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->whereHas('roles', function ($query) use ($roleId) {
            $query->where('id', $roleId);
        })->with($relations)->get($columns);
    }
}