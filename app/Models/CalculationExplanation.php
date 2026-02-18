<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalculationExplanation extends Model
{
    protected $fillable = [
        'calculation_id',
        'summary_ar',
        'summary_en',
        'reasons_ar',
        'reasons_en',
        'debug_payload',
    ];

    protected $casts = [
        'reasons_ar' => 'array',
        'reasons_en' => 'array',
        'debug_payload' => 'array',
    ];

    public function calculation(): BelongsTo
    {
        return $this->belongsTo(Calculation::class);
    }
}
