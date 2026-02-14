<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'title',
        'governorate',
        'road_name',
        'construction_date',
        'maintenance_date',
    ];

    public function calculations(): HasMany
    {
        return $this->hasMany(Calculation::class);
    }
}
