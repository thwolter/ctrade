<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Entities\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Entities\Portfolio::class, function(Faker\Generator $faker) {

    $currency = \App\Entities\Currency::firstOrCreate(
        ['code' => factory(\App\Entities\Currency::class)->make()->code]);

    return  [
        'user_id' => function() {
            return factory('App\Entities\User')->create()->id;
        },
        'name' => $faker->sentence,
        'currency' => $currency->id,
        'cash' => 100 * $faker->randomDigitNotNull
    ];
});



$factory->define(App\Entities\Stock::class, function(Faker\Generator $faker) {

    $currency = \App\Entities\Currency::firstOrCreate(
        ['code' => factory(\App\Entities\Currency::class)->make()->code]);

    return [
        'name' => $faker->company,
        'currency_id' => $currency->id
    ];
});


$factory->define(App\Entities\Position::class, function(Faker\Generator $faker) {

   return [
        'portfolio_id' => factory('App\Entities\Portfolio')->create()->id,
        'positionable_id' => factory('App\Entities\Stock')->create()->id,
        'positionable_type' => 'App\Entities\Stock',
        'amount' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\Entities\Currency::class, function(Faker\Generator $faker) {

    return [
        'code' => $faker->randomElement(['EUR', 'USD', 'CZK'])
    ];
});

$factory->define(App\Entities\Sector::class, function(Faker\Generator $faker) {

    return [
        'name' => $faker->word
    ];
});



$factory->define(\App\Entities\Dataset::class, function(Faker\Generator $faker) {

    return [
        'code' => $faker->word
    ];
});


$factory->define(\App\Entities\Database::class, function(Faker\Generator $faker) {

    return [
        'code' => $faker->word,
    ];
});


$factory->define(\App\Entities\Provider::class, function(Faker\Generator $faker) {

    return [
        'code' => $faker->word,
    ];
});