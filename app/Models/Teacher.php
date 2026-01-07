<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_code',
        'title',
        'firstname',
        'lastname',
        'citizen_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function advisedClassGroups()
    {
        return $this->hasMany(ClassGroup::class, 'teacher_advisor_id');
    }

    public function studyPlans()
    {
        return $this->hasMany(StudyPlan::class);
    }
}
