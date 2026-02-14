<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chart extends Model
{
    protected $fillable = [
        'calculation_id',
        'type',
        'image_path',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function calculation(): BelongsTo
    {
        return $this->belongsTo(Calculation::class);
    }
}
