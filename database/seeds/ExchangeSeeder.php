<?php

use App\Entities\Exchange;
use Illuminate\Database\Seeder;

class ExchangeSeeder extends Seeder
{

    protected $exchanges = [
        /*
         * German Exchanges
         */
        'Stuttgart' => [],
        'Hamburg' => [],
        'Frankfurt' => [],
        'Berlin' => [],
        'Munich' => ['München'],
        'Duesseldorf' => [],
        'Xetra' => [],
        'OTC' => ['außerbörslich Deutschland', 'over the counter Germany'],

        /*
         * European Exchanges
         */
        'Euronext Amsterdam' => [],
        'Euronext Brussels' => [],
        'Alternext Paris' => [],
        'Euronext Paris' => [],
        'NYSE Euronext Paris' => [],

        /*
         * Internationl Exchanges
         */
        'NYSE' => [],
        'BME Continuous Market' => [],
        'BME Latibex' => []
    ];


    public function run()
    {
        foreach ($this->exchanges as $key => $value)
        {
            Exchange::firstOrCreate(['code' => $key])->alias($value);
        }
    }
}
