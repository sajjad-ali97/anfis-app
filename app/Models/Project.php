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
        'maintenance_date',
    ];

    protected $casts = [
        'maintenance_date' => 'date',
    ];

    public function calculations(): HasMany
    {
        return $this->hasMany(Calculation::class);
    }

    // (اختياري) آخر حساب للمشروع
    public function latestCalculation()
    {
        return $this->hasOne(Calculation::class)->latestOfMany();
    }
}
