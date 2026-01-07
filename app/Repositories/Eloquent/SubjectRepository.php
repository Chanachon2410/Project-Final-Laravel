<?php

namespace App\Repositories\Eloquent;

use App\Models\Subject;
use App\Repositories\SubjectRepositoryInterface;

class SubjectRepository extends EloquentRepository implements SubjectRepositoryInterface
{
    /**
     * @var Subject
     */
    protected $model;

    /**
     * SubjectRepository constructor.
     * @param Subject $model
     */
    public function __construct(Subject $model)
    {
        parent::__construct($model);
    }
}