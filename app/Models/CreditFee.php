<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'semester',
        'year',
        'level_id',
        'credit_fee',
        'lab_fee',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
