<?php

use App\Entities\Asset;
use App\Entities\Portfolio;
use App\Entities\Position;
use App\Entities\Stock;
use Faker\Generator as Faker;

$factory->define(Position::class, function (Faker $faker) {

    $asset = factory(Asset::class)->create();

    return [
        'asset_id' => $asset->id,
        'amount' => $faker->randomDigitNotNull,
        'price' => $faker->randomFloat(2, 0, 200),
        'executed_at' => $faker->dateTimeBetween($asset->portfolio->opened_at)
    ];
});


$factory->state(Position::class, 'USD', function(Faker $faker) {

    $asset = factory(Asset::class)->states('USD')->create();

    return [
        'asset_id' => $asset->id,
        'executed_at' => $faker->dateTimeBetween($asset->portfolio->opened_at)
    ];
});


$factory->state(Position::class, 'EUR', function(Faker $faker) {

    $asset = factory(Asset::class)->states('EUR')->create();

    return [
        'asset_id' => $asset->id,
        'executed_at' => $faker->dateTimeBetween($asset->portfolio->opened_at)
    ];
});
