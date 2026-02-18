<?php

return [

    // أقل تأثير (٪) نعتبره “يستحق ذكره” بالنص
    'min_influence_pct' => 5.0,

    // عدد الأسباب الظاهرة بالنص (حتى لا يصير طويل)
    'max_reasons' => 7,

    // نصوص مستويات الـ Gauge (label_key)
    'gauge_labels' => [
        'very_low'  => ['ar' => 'منخفضة جداً', 'en' => 'Very Low'],
        'low'       => ['ar' => 'منخفضة',     'en' => 'Low'],
        'medium'    => ['ar' => 'متوسطة',     'en' => 'Medium'],
        'high'      => ['ar' => 'مرتفعة',     'en' => 'High'],
        'very_high' => ['ar' => 'مرتفعة جداً', 'en' => 'Very High'],
    ],

    // تعريف كل Feature: نوعه + كيف ننطق/نفسّر قيمه
    'features' => [

        // ===== Continuous (قيم رقمية) =====
        'pavement_area' => [
            'label_ar' => 'مساحة الطريق',
            'label_en' => 'Pavement Area',
            // نستخدم تصنيف بسيط قابل للتعديل لاحقاً
            'bands' => [
                ['max' => 15000, 'key' => 'small'],
                ['max' => 30000, 'key' => 'medium'],
                ['max' => INF,   'key' => 'large'],
            ],
            'texts' => [
                'small'  => ['ar' => 'مساحة الطريق صغيرة نسبيًا، وهذا يخفّف الكلفة الكلية عادةً.', 'en' => 'The pavement area is relatively small, which typically reduces the total cost.'],
                'medium' => ['ar' => 'مساحة الطريق متوسطة، وتأثيرها على الكلفة الكلية يكون معتدلًا.', 'en' => 'The pavement area is moderate, leading to a moderate impact on total cost.'],
                'large'  => ['ar' => 'مساحة الطريق كبيرة، وهذا يرفع الكلفة الكلية لأن حجم الأعمال والمواد أكبر.', 'en' => 'The pavement area is large, increasing total cost due to larger quantities of work and materials.'],
            ],
        ],

        'asphalt_thickness' => [
            'label_ar' => 'سمك الأسفلت',
            'label_en' => 'Asphalt Thickness',
            'bands' => [
                ['max' => 5,   'key' => 'thin'],
                ['max' => 10,  'key' => 'normal'],
                ['max' => INF, 'key' => 'thick'],
            ],
            'texts' => [
                'thin'   => ['ar' => 'سمك الأسفلت منخفض، وقد يشير إلى أعمال سطحية بكلفة أقل.', 'en' => 'Asphalt thickness is low, typically indicating a lighter treatment with lower cost.'],
                'normal' => ['ar' => 'سمك الأسفلت ضمن المدى الطبيعي، وتأثيره على الكلفة غالبًا متوازن.', 'en' => 'Asphalt thickness is within a typical range, giving a balanced cost impact.'],
                'thick'  => ['ar' => 'سمك الأسفلت مرتفع، وهذا غالبًا يرفع الكلفة بسبب زيادة المواد والتنفيذ.', 'en' => 'Asphalt thickness is high, often increasing cost due to more material and work.'],
            ],
        ],

        'hts' => [
            'label_ar' => 'شدة الحرارة العالية (HTS)',
            'label_en' => 'High Temperature Severity (HTS)',
            'bands' => [
                ['max' => 250, 'key' => 'low'],
                ['max' => 450, 'key' => 'medium'],
                ['max' => INF, 'key' => 'high'],
            ],
            'texts' => [
                'low'    => ['ar' => 'قيمة HTS منخفضة نسبيًا، ما يعني إجهاد حراري أقل على الرصف.', 'en' => 'HTS is relatively low, indicating lower thermal stress on the pavement.'],
                'medium' => ['ar' => 'قيمة HTS متوسطة، وقد تساهم بزيادة معتدلة في متطلبات الصيانة.', 'en' => 'HTS is moderate, potentially contributing to moderate maintenance demands.'],
                'high'   => ['ar' => 'قيمة HTS مرتفعة، وهذا يزيد إجهاد الحرارة على الرصف وقد يرفع كلفة الصيانة.', 'en' => 'HTS is high, increasing thermal stress and potentially raising maintenance cost.'],
            ],
        ],

        // ===== Categorical (أكواد) =====
        'pavement_age' => [
            'label_ar' => 'عمر الرصف',
            'label_en' => 'Pavement Age',
            'map' => [
                1 => ['ar' => 'عمر الرصف جديد، وهذا عادة يقلل الحاجة لأعمال علاجية مكلفة.', 'en' => 'The pavement is new, typically reducing the need for costly rehabilitation.'],
                2 => ['ar' => 'عمر الرصف متوسط، وقد يتطلب صيانة دورية بتكلفة متوسطة.', 'en' => 'The pavement age is moderate, often requiring routine maintenance with moderate cost.'],
                3 => ['ar' => 'عمر الرصف قديم، ما يزيد احتمالية التدهور ويؤدي عادةً لارتفاع الكلفة.', 'en' => 'The pavement is old, increasing deterioration likelihood and often raising cost.'],
            ],
        ],

        'road_condition' => [
            'label_ar' => 'حالة الطريق (PCI)',
            'label_en' => 'Road Condition (PCI)',
            'map' => [
                1 => ['ar' => 'حالة الطريق مقبولة (Fair)، وهذا يقلل حجم المعالجة المطلوبة.', 'en' => 'Condition is Fair, typically reducing required intervention.'],
                2 => ['ar' => 'حالة الطريق سيئة (Poor)، وقد تتطلب أعمال علاجية أكبر.', 'en' => 'Condition is Poor, which may require more extensive treatment.'],
                3 => ['ar' => 'حالة الطريق سيئة جداً (Very Poor)، وهذا غالباً يرفع الكلفة بسبب تدخلات أعمق.', 'en' => 'Condition is Very Poor, often increasing cost due to deeper interventions.'],
            ],
        ],

        'aadt_heavy' => [
            'label_ar' => 'مرور الشاحنات الثقيلة',
            'label_en' => 'AADT Heavy',
            'map' => [
                1 => ['ar' => 'مرور الشاحنات الثقيلة منخفض، ما يقلل إجهاد الأحمال على الرصف.', 'en' => 'Heavy-vehicle traffic is low, reducing load stress on pavement.'],
                2 => ['ar' => 'مرور الشاحنات الثقيلة متوسط، وتأثيره على الكلفة يكون ملحوظاً بشكل معتدل.', 'en' => 'Heavy-vehicle traffic is moderate, with a moderate cost impact.'],
                3 => ['ar' => 'مرور الشاحنات الثقيلة مرتفع، ما يزيد التلف ويؤدي غالباً لارتفاع الكلفة.', 'en' => 'Heavy-vehicle traffic is high, increasing damage and often raising cost.'],
            ],
        ],

        'soil_strength' => [
            'label_ar' => 'قوة التربة',
            'label_en' => 'Soil Strength',
            'map' => [
                1 => ['ar' => 'التربة ضعيفة، وقد تتطلب تقوية/طبقات إضافية مما يزيد الكلفة.', 'en' => 'Soil is weak; stabilization or extra layers may be needed, increasing cost.'],
                2 => ['ar' => 'التربة متوسطة، وتأثيرها على الكلفة يكون عادةً متوسطاً.', 'en' => 'Soil strength is medium, usually causing a moderate cost impact.'],
                3 => ['ar' => 'التربة قوية، ما يقلل الحاجة لأعمال تقوية كبيرة.', 'en' => 'Soil is strong, reducing the need for heavy stabilization works.'],
            ],
        ],

        'traffic_volume' => [
            'label_ar' => 'حجم المرور (AADT)',
            'label_en' => 'Traffic Volume (AADT)',
            'map' => [
                1 => ['ar' => 'حجم المرور منخفض، ما يقلل متطلبات التحمل والصيانة.', 'en' => 'Traffic volume is low, reducing durability and maintenance demands.'],
                2 => ['ar' => 'حجم المرور متوسط، وتأثيره على الكلفة يكون معتدلاً.', 'en' => 'Traffic volume is medium with a moderate cost effect.'],
                3 => ['ar' => 'حجم المرور مرتفع، وقد يرفع الكلفة بسبب متطلبات أعلى للتحمل.', 'en' => 'Traffic volume is high, potentially raising cost due to higher performance demands.'],
            ],
        ],

        'maintenance_type' => [
            'label_ar' => 'نوع الصيانة',
            'label_en' => 'Maintenance Type',
            'map' => [
                1 => ['ar' => 'الصيانة وقائية، وغالبًا تكون أقل كلفة من التدخلات الطارئة.', 'en' => 'Preventive maintenance is typically cheaper than emergency actions.'],
                2 => ['ar' => 'الصيانة اعتيادية، وكلفتها غالبًا ضمن المدى المتوسط.', 'en' => 'Routine maintenance generally falls in the mid-cost range.'],
                3 => ['ar' => 'الصيانة طارئة، وغالبًا ترتفع كلفتها بسبب سرعة التنفيذ وحجم الضرر.', 'en' => 'Emergency maintenance is often more expensive due to urgency and severity.'],
            ],
        ],
    ],
];
