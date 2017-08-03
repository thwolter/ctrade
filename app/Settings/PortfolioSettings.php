<?php


namespace App\Settings;


class PortfolioSettings extends Settings
{
    protected $settings = [
        'confidence' => 0.95,
        'period' => 20,
        'history' => 250,
        'email_frequency' => 'daily',
        'threshold' => 0,

        'abs_limit' => null,
        'abs_limit_value' => null,

        'rel_limit' => null,
        'rel_limit_value' => null,

        'floor_limit' => null,
        'floor_limit_value' => null,

        'target_limit' => null,
        'target_limit_value' => null,
        'target_limit_date' => null
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

    /**
     * Handles the request form checkboxes. If not checked, no value is provided with the
     * request and setting by 'merge' fails to disable a checkbox settings in database.
     * This function calls the relevant checkbox values and set value to null if not provided.
     *
     * @param $attributes
     */
    public function setLimitDeactivation($attributes)
    {
        $limits = [
            'abs_limit',
            'rel_limit',
            'floor_limit',
            'target_limit'
        ];

        foreach ($limits as $limit)
        {
            if (! array_key_exists($limit, $attributes)) {
                $this->set($limit, null);
                $this->set($limit . '_value', null);
            }
        }

        if (! $this->get('target_limit'))
            $this->set('target_limit_date', null);
    }
}