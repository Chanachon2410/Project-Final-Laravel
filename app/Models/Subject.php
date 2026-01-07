<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_code',
        'subject_name',
        'credit',
        'hour_theory',
        'hour_practical',
    ];

    public function studyPlans()
    {
        return $this->hasMany(StudyPlan::class);
    }
}
