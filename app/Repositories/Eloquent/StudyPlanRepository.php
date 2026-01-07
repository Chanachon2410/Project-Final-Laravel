<?php

namespace App\Repositories\Eloquent;

use App\Models\StudyPlan;
use App\Repositories\StudyPlanRepositoryInterface;

class StudyPlanRepository extends EloquentRepository implements StudyPlanRepositoryInterface
{
    /**
     * @var StudyPlan
     */
    protected $model;

    /**
     * StudyPlanRepository constructor.
     * @param StudyPlan $model
     */
    public function __construct(StudyPlan $model)
    {
        parent::__construct($model);
    }
}