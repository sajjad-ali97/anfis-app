<?php

return [
    'required' => 'حقل :attribute مطلوب.',
    'string'   => 'يجب أن يكون :attribute نصاً.',
    'numeric'  => 'يجب أن تكون قيمة :attribute رقمية.',
    'date'     => 'يجب أن يكون :attribute تاريخاً صحيحاً.',
    'in'       => 'القيمة المختارة في :attribute غير صحيحة.',

    'min' => [
        'numeric' => 'يجب ألا تقل قيمة :attribute عن :min.',
        'string'  => 'يجب ألا يقل :attribute عن :min أحرف.',
    ],

    'max' => [
        'string'  => 'يجب ألا يزيد :attribute عن :max حرفاً.',
    ],

    'attributes' => [
        // تقدر تتركها فاضية لأننا استخدمنا attributes() بالـ Request
    ],
];
