<?php

namespace App\Settings;

use LaravelPropertyBag\Settings\ResourceConfig;

class PortfolioSettings extends ResourceConfig
{
    /**
     * Registered settings for the user. Register settings by setting name. Each
     * setting must have an associative array set as its value that contains an
     * array of 'allowed' values and a single 'default' value.
     *
     * @var array
     */
    protected $registeredSettings = [

        'confidence_level' => [
            'allowed' => ':range=0,1:',
            'default' => 0.95
        ],

        'horizon' => [
            'allowed' => ':int:',
            'default' => 20
        ]

        // 'example_setting' => [
        //     'allowed' => [true, false],
        //     'default' => true
        // ]

    ];
}
