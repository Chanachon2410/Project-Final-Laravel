<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentStructure extends Model
{
    protected $fillable = [
        'name',
        'semester',
        'year',
        'major_id',
        'level_id',
        'company_code',
        'custom_ref2',
        'payment_start_date',
        'payment_end_date',
        'late_payment_start_date',
        'late_payment_end_date',
    ];

    protected $casts = [
        'payment_start_date' => 'date',
        'payment_end_date' => 'date',
        'late_payment_start_date' => 'date',
        'late_payment_end_date' => 'date',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(PaymentStructureItem::class)->orderBy('sort_order');
    }

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function getTotalAmountAttribute()
    {
        return $this->items->sum('amount');
    }
}