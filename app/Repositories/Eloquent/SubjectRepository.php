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

    public function search(string $search, int $perPage)
    {
        return $this->model->query()
            ->where(function ($query) use ($search) {
                $query->where('subject_code', 'like', "%{$search}%")
                      ->orWhere('subject_name', 'like', "%{$search}%");
            })
            ->paginate($perPage);
    }
}