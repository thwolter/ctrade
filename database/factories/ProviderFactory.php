<?php

use App\Entities\Provider;
use Faker\Generator as Faker;

$factory->define(Provider::class, function (Faker $faker) {
    return [
        'code' => $faker->word
    ];
});
