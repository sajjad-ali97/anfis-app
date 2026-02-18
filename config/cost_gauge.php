<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cost Per m² Classification Ranges
    |--------------------------------------------------------------------------
    | A = cost / pavement_area  (IQD per m²)
    | Condition format:  min <= A < max
    */

    'ranges' => [

        [
            'key' => 'very_low',
            'ar'  => 'واطئة جداً',
            'en'  => 'Very Low',
            'min' => 10000,
            'max' => 15000,
            'color' => '#3b82f6', // اختياري للـ gauge
        ],

        [
            'key' => 'low',
            'ar'  => 'واطئة',
            'en'  => 'Low',
            'min' => 15000,
            'max' => 19000,
            'color' => '#22c55e',
        ],

        [
            'key' => 'medium',
            'ar'  => 'متوسطة',
            'en'  => 'Medium',
            'min' => 19000,
            'max' => 23000,
            'color' => '#f59e0b',
        ],

        [
            'key' => 'high',
            'ar'  => 'عالية',
            'en'  => 'High',
            'min' => 23000,
            'max' => 26500,
            'color' => '#ef4444',
        ],

        [
            'key' => 'very_high',
            'ar'  => 'عالية جداً',
            'en'  => 'Very High',
            'min' => 26500,
            'max' => 36000,
            'color' => '#7c3aed',
        ],

    ],

];
