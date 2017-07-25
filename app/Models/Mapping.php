<?php


namespace App\Models;


class Mapping
{

    public function confidenceValues()
    {
        return [
            '1' => 'hohe Sicherheit',
            '2' => 'ausgewogen',
            '3' => 'risikofreudig'
        ];
    }

    public function confidence($key)
    {
        return array_get([
            '1' => 0.975,
            '2' => 0.95,
            '3' => 0.9
        ], $key);
    }

    public function horizonValues()
    {
        return [
        '1' =>'1 Tag',
        '2' => '1 Woche',
        '3' => '1 Monat',
        '4' => '6 Monate',
        '5' => '1 Jahr'
        ];
    }
    public function horizon($key)
    {
        return array_get([
            '1' => 1,
            '2' => 5,
            '3' => 20,
            '4' => 125,
            '5' => 250
        ], $key);
    }

    public function frequencyValues()
    {
        return [
            '0' => 'keine Emails',
            '1' => 'täglich',
            '2' => 'wöchentlich',
            '3' => 'monatlich'
        ];
    }

    public function frequency($key)
    {
        return array_get([
            '0' => 'none',
            '1' => 'daily',
            '2' => 'weekly',
            '3' => 'monthly',
        ], $key);
    }


}