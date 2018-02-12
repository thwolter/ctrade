<?php

use App\Entities\Payment;
use App\Entities\Portfolio;
use App\Entities\Position;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {

    return [
        'portfolio_id' => factory(Portfolio::class)->create()->id,
        'position_id' => factory(Position::class)->create()->id,
        'type' => $faker->randomElement(['fee', 'payment', 'settlement']),
        'amount' => $faker->randomFloat(2),
        'executed_at' => $faker->dateTimeBetween('-3month')
    ];
});
