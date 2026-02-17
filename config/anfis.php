<?php

return [



    'model' => [
        // خزّن ملفاتك بمكان ثابت (مثلاً storage/app/anfis)
        'fis_path' => storage_path('app/anfis/Best_ANFIS_Model_No5.fis'),
    ],

    // mapminmax params (PS_in / PS_out) من Model_Parameters.mat
    'ps_in' => [
        'gain' => [
            0.34874875,
            3.22351345,
            3.19879276,
            2.59114363,
            5.67887359,
            3.30853137,
            3.26386395,
            3.30622796,
            5.48657939,
            1.78525257,
            3.28865457,
            3.28363245,
            3.26168125
        ],
        'xoffset' => [
            1.98227123,
            0.29888735,
            0.29804161,
            0.84509804,
            0.30103,
            0.30080306,
            0.30103,
            0.30037111,
            0.29819368,
            2.20951501,
            0.29949716,
            0.0,
            0.0
        ],
        'ymin' => 0.0,
        'yrange' => 1.0,
    ],

    'ps_out' => [
        'gain' => 0.32620453,
        'xoffset' => 6.02489637,
        'ymin' => 0.0,
        'yrange' => 1.0,
    ],



    'codes' => [

        'pavement_age'      => [1, 2, 3], // New, Medium, Old
        'road_condition'    => [1, 2, 3], // Fair, Poor, Very Poor
        'pavement_type'     => [1, 2],    // Asphalt, Mix
        'maintenance_type'  => [1, 2, 3], // Preventive, Routine, Emergency
        'traffic_volume'    => [1, 2, 3], // Low, Medium, High
        'aadt_heavy'        => [1, 2, 3], // Low, Medium, High
        'road_class'        => [1, 2],    // Main, Secondary
        'soil_strength'     => [1, 2, 3], // Weak, Medium, Strong

        // binary fields
        'binary'            => [0, 1],    // Exist / None

    ],

];
