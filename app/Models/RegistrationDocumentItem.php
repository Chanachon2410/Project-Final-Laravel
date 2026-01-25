<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistrationDocumentItem extends Model
{
    protected $fillable = [
        'registration_document_id',
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

    public function registrationDocument(): BelongsTo
    {
        return $this->belongsTo(RegistrationDocument::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}