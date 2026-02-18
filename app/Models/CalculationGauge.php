<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalculationGauge extends Model
{
    protected $fillable = [
        'calculation_id',

        'a',
        'label_key',
        'label',

        'range_min',
        'range_max',
        'range_color',

        'min',
        'max',

        'ranges_json',
    ];

    protected $casts = [
        'a' => 'decimal:2',
        'range_min' => 'integer',
        'range_max' => 'integer',
        'min' => 'integer',
        'max' => 'integer',
        'ranges_json' => 'array', // json <-> array
    ];

    public function calculation(): BelongsTo
    {
        return $this->belongsTo(Calculation::class);
    }
}
