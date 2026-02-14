<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeatDay extends Model
{
    protected $fillable = [
        'governorate',
        'year',
        'days_over_45',
    ];
}
