<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentStructureItem extends Model
{
    protected $fillable = [
        'payment_structure_id',
        'name',
        'amount',
        'is_subject',
        'subject_id',
        'credit',
        'theory_hour',
        'practical_hour',
        'sort_order',
    ];

    protected $casts = [
        'is_subject' => 'boolean',
        'amount' => 'decimal:2',
        'credit' => 'decimal:1',
    ];

    public function paymentStructure(): BelongsTo
    {
        return $this->belongsTo(PaymentStructure::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}