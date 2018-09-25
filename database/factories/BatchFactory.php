<?php

use Faker\Generator as Faker;

$factory->define(App\Batch::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->numberBetween($min = 1, $max = 100)
    ];
});
