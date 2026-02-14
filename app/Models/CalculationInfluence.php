<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalculationInfluence extends Model
{
    protected $fillable = [
        'calculation_id',
        'input_key',
        'influence_percent',
        'delta_cost',
        'direction',
        'rank',
    ];

    public function calculation(): BelongsTo
    {
        return $this->belongsTo(Calculation::class);
    }
}
