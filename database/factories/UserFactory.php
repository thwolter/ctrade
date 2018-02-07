<?php

use App\Entities\User;
use Faker\Generator as Faker;


$factory->define(User::class, function (Faker $faker) {

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('secret'),
        'verified' => true,
        'remember_token' => str_random(10),
    ];
});
