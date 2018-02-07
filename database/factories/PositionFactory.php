<?php

use App\Entities\Portfolio;
use App\Entities\Position;
use App\Entities\Stock;
use Faker\Generator as Faker;

$factory->define(Position::class, function (Faker $faker) {

    return [
        'portfolio_id' => factory(Portfolio::class)->create()->id,
        'positionable_id' => factory(Stock::class)->create()->id,
        'positionable_type' => Stock::class,
        'amount' => $faker->randomDigitNotNull
    ];

});
