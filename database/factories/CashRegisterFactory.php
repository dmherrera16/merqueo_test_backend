<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CashRegister;
use Faker\Generator as Faker;

$factory->define(CashRegister::class, function (Faker $faker) {
    return [
        'denomination' => $faker->randomElement(['billete', 'moneda']),
        'value' => $faker->randomElement([50,100,200,500,1000,5000,10000,20000,50000,100000]),
        'quantity' => $faker->randomNumber(1),
    ];
});
