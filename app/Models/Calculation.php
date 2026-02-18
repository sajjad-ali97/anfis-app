<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Calculation extends Model
{
    protected $fillable = [
        'project_id',

        // inputs 13
        'pavement_area_m2',
        'pavement_age_code',
        'pci_code',
        'asphalt_thickness_cm',
        'pavement_type_code',
        'maintenance_type_code',
        'aadt_code',
        'aadt_heavy_code',
        'road_class_code',
        'hts_days_over_45',
        'soil_strength_code',
        'median_islands',
        'drainage_system',

        // outputs
        'estimated_cost',
    ];

    protected $casts = [
        'pavement_area_m2' => 'decimal:2',
        'asphalt_thickness_cm' => 'decimal:2',
        'estimated_cost' => 'integer',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function gauge(): HasOne
    {
        return $this->hasOne(CalculationGauge::class);
    }
    public function sensitivity()
    {
        return $this->hasOne(CalculationSensitivity::class);
    }
    public function explanation()
    {
        return $this->hasOne(CalculationExplanation::class);
    }
}
