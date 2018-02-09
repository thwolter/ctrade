<?php

use App\Entities\Database;
use App\Entities\Dataset;
use App\Entities\Datasource;
use App\Entities\Exchange;
use App\Entities\Provider;
use Faker\Generator as Faker;


$factory->define(Datasource::class, function (Faker $faker) {

    return [
        'provider_id' => factory(Provider::class)->create()->id,
        'database_id' => factory(Database::class)->create()->id,
        'dataset_id' => factory(Dataset::class)->create()->id,
        'exchange_id' => factory(Exchange::class)->create()->id,
        'valid' => $faker->randomElement([0, 1])
    ];
});


$factory->state(Datasource::class, 'Quandl', function() {
    return [
        'provider_id' => Provider::firstOrCreate(['code' => 'Quandl'])
    ];
});


$factory->state(Datasource::class, 'stock', function (Faker $faker) {

    return [
        'provider_id' => Provider::firstOrCreate(['code' => 'Quandl']),
        'database_id' => Database::firstOrCreate(['code' => 'SSE']),
        'dataset_id' => Dataset::firstOrCreate(['code' => 'NA8P']),
        'exchange_id' => Exchange::firstOrCreate(['code' => 'Stuttgart']),
        'valid' => 1
    ];
});

$factory->state(Datasource::class, 'USD', function (Faker $faker) {

    return [
        'provider_id' => Provider::firstOrCreate(['code' => 'Quandl']),
        'database_id' => Database::firstOrCreate(['code' => 'ECB']),
        'dataset_id' => Dataset::firstOrCreate(['code' => 'EURUSD']),
        'exchange_id' => Exchange::firstOrCreate(['code' => 'ECB']),
        'valid' => 1
    ];
});

$factory->state(Datasource::class, 'CHF', function (Faker $faker) {

    return [
        'provider_id' => Provider::firstOrCreate(['code' => 'Quandl']),
        'database_id' => Database::firstOrCreate(['code' => 'ECB']),
        'dataset_id' => Dataset::firstOrCreate(['code' => 'EURCHF']),
        'exchange_id' => Exchange::firstOrCreate(['code' => 'ECB']),
        'valid' => 1
    ];
});
