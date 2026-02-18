<?php

return [

    'top_n' => 10, // الآن صاروا 10 متغيرات

    'continuous_perturbation_percent' => 10,

    'features' => [

        // ===== Continuous =====

        'pavement_area' => [
            'type' => 'continuous',
            'label_ar' => 'مساحة الطريق',
            'label_en' => 'Pavement Area',
        ],

        'asphalt_thickness' => [
            'type' => 'continuous',
            'label_ar' => 'سمك الأسفلت',
            'label_en' => 'Asphalt Thickness',
        ],

        'hts' => [
            'type' => 'continuous',
            'label_ar' => 'مؤشر شدة الحرارة',
            'label_en' => 'High Temperature Severity',
        ],

        // ===== Categorical =====

        'pavement_age' => [
            'type' => 'categorical',
            'label_ar' => 'عمر الرصف',
            'label_en' => 'Pavement Age',
            'values' => [1, 2, 3],
        ],

        'road_condition' => [
            'type' => 'categorical',
            'label_ar' => 'حالة الطريق',
            'label_en' => 'Road Condition',
            'values' => [1, 2, 3],
        ],

        'pavement_type' => [
            'type' => 'categorical',
            'label_ar' => 'نوع الرصف',
            'label_en' => 'Pavement Type',
            'values' => [1, 2],
        ],

        'maintenance_type' => [
            'type' => 'categorical',
            'label_ar' => 'نوع الصيانة',
            'label_en' => 'Maintenance Type',
            'values' => [1, 2, 3],
        ],

        'traffic_volume' => [
            'type' => 'categorical',
            'label_ar' => 'حجم المرور',
            'label_en' => 'Traffic Volume',
            'values' => [1, 2, 3],
        ],

        'aadt_heavy' => [
            'type' => 'categorical',
            'label_ar' => 'مرور الشاحنات الثقيلة',
            'label_en' => 'AADT Heavy',
            'values' => [1, 2, 3],
        ],

        'soil_strength' => [
            'type' => 'categorical',
            'label_ar' => 'قوة التربة',
            'label_en' => 'Soil Strength',
            'values' => [1, 2, 3],
        ],
    ],
];
