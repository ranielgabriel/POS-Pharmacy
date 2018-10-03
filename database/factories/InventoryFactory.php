<?php

use Faker\Generator as Faker;

$factory->define(App\Inventory::class, function (Faker $faker) {
    return [
        'supplier_id' => $faker->numberBetween($min = 1, $max = 5),
        'product_id' => $faker->numberBetween($min = 1, $max = 22),
        'quantity'=> $faker->numberBetween($min = 50, $max = 100),
        'sold' => $faker->numberBetween($min = 0, $max = 50),
        'expiration_date' => $faker->unique()->dateTimeBetween($startDate = '-3 months', $endDate = '+2 years', $timezone = null),
        'batch_number' => $faker->numberBetween($min = 50, $max = 100),
        'delivery_date' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+1 week', $timezone = null),
        'isReturn' => '0'
    ];
});

