<?php

use Faker\Generator as Faker;

$factory->define(App\Sale::class, function (Faker $faker) {
    return [
        'id' => null,
        'customer_id' => $faker->numberBetween($min = 1, $max = 20),
        'sale_date' => $faker->dateTimeBetween($startDate = '-1 year', $endDate = 'now', $timezone = null)
    ];
});
