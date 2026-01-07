<?php

namespace App\Repositories\Eloquent;

use App\Models\ClassGroup;
use App\Repositories\ClassGroupRepositoryInterface;

class ClassGroupRepository extends EloquentRepository implements ClassGroupRepositoryInterface
{
    /**
     * @var ClassGroup
     */
    protected $model;

    /**
     * ClassGroupRepository constructor.
     * @param ClassGroup $model
     */
    public function __construct(ClassGroup $model)
    {
        parent::__construct($model);
    }
}