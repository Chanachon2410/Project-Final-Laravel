<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'semester',
        'year',
        'status',
        'registration_card_file',
        'slip_file_name',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
