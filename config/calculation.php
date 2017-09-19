<?php

return [


    /*
    |--------------------------------------------------------------------------
    | Chunk Size
    |--------------------------------------------------------------------------
    |
    | Specify the number of dates which should be calculated synchronously
    | within a single foreach loop.
    */

    'chunk' => [
        'risk'  => 50,
        'value' => 50
    ],



    /*
    |--------------------------------------------------------------------------
    | History Length
    |--------------------------------------------------------------------------
    |
    | The number of historical period to be used for risk calculation.
    */

    'risk' => [
        'period' => 250,
    ]

];
