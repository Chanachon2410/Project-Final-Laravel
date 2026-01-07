<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function classGroups()
    {
        return $this->hasMany(ClassGroup::class);
    }

    public function creditFees()
    {
        return $this->hasMany(CreditFee::class);
    }
}
