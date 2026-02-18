<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalculationSensitivity extends Model
{
    protected $fillable = [
        'calculation_id',
        'bar_data',
        'debug_payload',
        'top_n',
        'perturb_percent',
    ];

    protected $casts = [
        'bar_data' => 'array',
        'debug_payload' => 'array',
        'top_n' => 'integer',
        'perturb_percent' => 'float',
    ];

    public function calculation(): BelongsTo
    {
        return $this->belongsTo(Calculation::class);
    }
}
