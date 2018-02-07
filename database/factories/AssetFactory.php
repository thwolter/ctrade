<?php

use App\Entities\Asset;
use App\Entities\Portfolio;
use App\Entities\Stock;
use Faker\Generator as Faker;

$factory->define(Asset::class, function (Faker $faker) {
    return [
        'portfolio_id' => factory(Portfolio::class)->create()->id,
        'positionable_type' => Stock::class,
        'positionable_id' => factory(Stock::class)->create()->id
    ];
});

$factory->state(Asset::class, 'USD', function() {
    return [
        'positionable_id' => factory(Stock::class)->states('USD')->create()->id
    ];
});


$factory->state(Asset::class, 'EUR', function() {
    return [
        'positionable_id' => factory(Stock::class)->states('EUR')->create()->id
    ];
});
