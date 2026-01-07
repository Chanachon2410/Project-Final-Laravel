<?php

namespace App\Repositories\Eloquent;

use App\Models\CreditFee;
use App\Repositories\CreditFeeRepositoryInterface;

class CreditFeeRepository extends EloquentRepository implements CreditFeeRepositoryInterface
{
    /**
     * @var CreditFee
     */
    protected $model;

    /**
     * CreditFeeRepository constructor.
     * @param CreditFee $model
     */
    public function __construct(CreditFee $model)
    {
        parent::__construct($model);
    }
}