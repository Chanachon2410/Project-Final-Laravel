<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'semester',
        'year',
        'registration_start_date',
        'registration_end_date',
        'late_registration_start_date',
        'late_registration_end_date',
        'late_fee_rate',
        'is_active',
    ];

    protected $casts = [
        'registration_start_date' => 'datetime',
        'registration_end_date' => 'datetime',
        'late_registration_start_date' => 'datetime',
        'late_registration_end_date' => 'datetime',
        'is_active' => 'boolean',
    ];
}
