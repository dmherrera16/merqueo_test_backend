<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Movements;
use Faker\Generator as Faker;

$factory->define(Movements::class, function (Faker $faker) {
    return [
        'type' => $faker->randomElement(['ingreso', 'egreso']),
        'amount' => $faker->randomElement([50,100,200,500,1000,5000,10000,20000,50000,100000]),
    ];
});
