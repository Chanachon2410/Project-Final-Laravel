<?php

namespace App\Repositories\Eloquent;

use App\Models\Teacher;
use App\Repositories\TeacherRepositoryInterface;

class TeacherRepository extends EloquentRepository implements TeacherRepositoryInterface
{
    /**
     * @var Teacher
     */
    protected $model;

    /**
     * TeacherRepository constructor.
     * @param Teacher $model
     */
    public function __construct(Teacher $model)
    {
        parent::__construct($model);
    }
}