<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Eloquent\EloquentRepository;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends EloquentRepository implements UserRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Update a user and sync their roles.
     *
     * @param int $id
     * @param array $attributes
     * @param string|null $roleName
     * @return Model
     */
    public function updateUserAndRole(int $id, array $attributes, ?string $roleName = null): Model
    {
        $user = $this->model->findOrFail($id);
        $user->update($attributes);

        if ($roleName) {
            $user->syncRoles($roleName);
        }

        return $user;
    }
}