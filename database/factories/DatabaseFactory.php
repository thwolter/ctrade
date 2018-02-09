<?php

use App\Entities\Database;
use Faker\Generator as Faker;

$factory->define(Database::class, function (Faker $faker) {
    return [
        'code' => $faker->word
    ];
});
