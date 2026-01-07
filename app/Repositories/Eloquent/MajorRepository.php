<?php

namespace App\Repositories\Eloquent;

use App\Models\Major;
use App\Repositories\MajorRepositoryInterface;

class MajorRepository extends EloquentRepository implements MajorRepositoryInterface
{
    /**
     * @var Major
     */
    protected $model;

    /**
     * MajorRepository constructor.
     * @param Major $model
     */
    public function __construct(Major $model)
    {
        parent::__construct($model);
    }
}