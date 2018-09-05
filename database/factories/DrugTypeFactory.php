<?php

use Faker\Generator as Faker;

$factory->define(App\DrugType::class, function (Faker $faker) {
    return [
        'description' => $faker->word()
    ];
});
