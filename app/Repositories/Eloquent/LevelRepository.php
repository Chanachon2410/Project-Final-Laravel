<?php

namespace App\Repositories\Eloquent;

use App\Models\Level;
use App\Repositories\LevelRepositoryInterface;

class LevelRepository extends EloquentRepository implements LevelRepositoryInterface
{
    /**
     * @var Level
     */
    protected $model;

    /**
     * LevelRepository constructor.
     * @param Level $model
     */
    public function __construct(Level $model)
    {
        parent::__construct($model);
    }
}