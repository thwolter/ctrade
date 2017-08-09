<?php

use Illuminate\Database\Seeder;
use App\Entities\Currency;
use App\Repositories\DatasourceRepository;
use App\Entities\CcyPair;

class CurrencySeeder extends Seeder
{

    protected $repo;

    protected $baseCurrency = 'EUR';


    public function __construct()
    {
        $this->repo = new DatasourceRepository();
    }


    public function run()
    {
        Currency::firstOrCreate(['code' => $this->baseCurrency]);

        $this->createForeignCurrency('USD');
        $this->createForeignCurrency('CHF');

    }

    public function createForeignCurrency($code)
    {
        Currency::firstOrCreate(['code' => $code]);

        $datasource = $this->repo->create([
            'provider' => 'Quandl',
            'database' => 'ECB',
            'dataset' => $this->baseCurrency.$code,
            'exchange' => 'ECB'
        ]);

        $datasource->assign(CcyPair::firstOrCreate([
            'origin' => $this->baseCurrency, 'target' => $code
        ]));
    }
}
