<?php

namespace App\Repositories\Eloquent;

use App\Models\Student;
use App\Repositories\StudentRepositoryInterface;

class StudentRepository extends EloquentRepository implements StudentRepositoryInterface
{
    /**
     * @var Student
     */
    protected $model;

    /**
     * StudentRepository constructor.
     * @param Student $model
     */
    public function __construct(Student $model)
    {
        parent::__construct($model);
    }
}