<?php

use Faker\Generator as Faker;

$factory->define(App\ProductSale::class, function (Faker $faker) {
    return [
        'id' => null,
        'product_id' => $faker->numberBetween($min = 1, $max = 22),
        'sale_id' => $faker->numberBetween($min = 1, $max = 250),
        'inventory_id' => $faker->numberBetween($min = 1, $max = 500),
        'quantity' => $faker->numberBetween($min = 1, $max = 23),
        'price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000)
    ];
});
