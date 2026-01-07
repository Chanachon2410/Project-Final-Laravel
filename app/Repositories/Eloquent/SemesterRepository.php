<?php

namespace App\Repositories\Eloquent;

use App\Models\Semester;
use App\Repositories\SemesterRepositoryInterface;

class SemesterRepository extends EloquentRepository implements SemesterRepositoryInterface
{
    /**
     * @var Semester
     */
    protected $model;

    /**
     * SemesterRepository constructor.
     * @param Semester $model
     */
    public function __construct(Semester $model)
    {
        parent::__construct($model);
    }
}