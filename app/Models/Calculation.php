<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Calculation extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Mass Assignment
    |--------------------------------------------------------------------------
    */
    protected $fillable = [

        'project_id',

        'pavement_area_m2',
        'pavement_age_code',
        'median_islands',
        'asphalt_thickness_cm',
        'hts_days_over_45',
        'road_class_code',
        'pci_code',
        'aadt_heavy_code',
        'drainage_system',
        'maintenance_type_code',
        'soil_strength_code',
        'pavement_type_code',
        'aadt_code',

        'estimated_cost',
        'gauge_value',
        'gauge_level',
        'explanation',
    ];


    /*
    |--------------------------------------------------------------------------
    | Type Casting (مهم جداً للدقة)
    |--------------------------------------------------------------------------
    */
    protected $casts = [

        'pavement_area_m2'      => 'decimal:2',
        'asphalt_thickness_cm'  => 'decimal:2',
        'gauge_value'           => 'decimal:2',

        'estimated_cost'        => 'integer',
        'hts_days_over_45'      => 'integer',

        'pavement_age_code'     => 'integer',
        'median_islands'        => 'integer',
        'road_class_code'       => 'integer',
        'pci_code'              => 'integer',
        'aadt_heavy_code'       => 'integer',
        'drainage_system'       => 'integer',
        'maintenance_type_code' => 'integer',
        'soil_strength_code'    => 'integer',
        'pavement_type_code'    => 'integer',
        'aadt_code'             => 'integer',
    ];


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function influences(): HasMany
    {
        return $this->hasMany(CalculationInfluence::class);
    }

    public function charts(): HasMany
    {
        return $this->hasMany(Chart::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Helper Methods (مفيدة لاحقاً)
    |--------------------------------------------------------------------------
    */

    public function isHighCost(): bool
    {
        return $this->gauge_level === 'high' || $this->gauge_level === 'very_high';
    }

    public function isLowCost(): bool
    {
        return $this->gauge_level === 'low' || $this->gauge_level === 'very_low';
    }
}
