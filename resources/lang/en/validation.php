<?php

return [
    'required' => 'The :attribute field is required.',
    'string'   => 'The :attribute must be a string.',
    'numeric'  => 'The :attribute must be a number.',
    'date'     => 'The :attribute is not a valid date.',
    'in'       => 'The selected :attribute is invalid.',

    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'string'  => 'The :attribute must be at least :min characters.',
    ],

    'max' => [
        'string'  => 'The :attribute may not be greater than :max characters.',
    ],

    'attributes' => [
        // تقدر تتركها فاضية لأننا استخدمنا attributes() بالـ Request
    ],
];
