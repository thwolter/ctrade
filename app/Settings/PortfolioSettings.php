<?php


namespace App\Settings;


class PortfolioSettings extends Settings
{
    protected $settings = [
        'confidence' => 0.95,
        'period' => 20,
        'history' => 250,
        'email_frequency' => 'daily',
        'threshold' => 0
    ];

    protected $confidence = [
        'hohe Sicherheit' => 0.99,
        'ausgewogen' => 0.975,
        'risikofreudig' => 0.95,
    ];

    public $period = [
        '1 Tag' => 1,
        '1 Woche' => 5,
        '1 Monat' => 20,
        '6 Monate' => 120,
        '1 Jahr' => 250
    ];

    protected $history = [
        '6 Monate' => 120,
        '1 Jahr' => 250,
        '2 Jahre' => 500,
    ];
}