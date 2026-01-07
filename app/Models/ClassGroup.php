<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_group_code',
        'course_group_name',
        'level_id',
        'level_year',
        'major_id',
        'teacher_advisor_id',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function advisor()
    {
        return $this->belongsTo(Teacher::class, 'teacher_advisor_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function studyPlans()
    {
        return $this->hasMany(StudyPlan::class);
    }
}
