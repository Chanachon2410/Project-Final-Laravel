<?php

namespace App\Repositories\Eloquent;

use App\Models\TuitionFee;
use App\Repositories\TuitionFeeRepositoryInterface;

class TuitionFeeRepository extends EloquentRepository implements TuitionFeeRepositoryInterface
{
    /**
     * @var TuitionFee
     */
    protected $model;

    /**
     * TuitionFeeRepository constructor.
     * @param TuitionFee $model
     */
    public function __construct(TuitionFee $model)
    {
        parent::__construct($model);
    }
}