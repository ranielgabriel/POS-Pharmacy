<?php

use Faker\Generator as Faker;

$factory->define(App\DrugType::class, function (Faker $faker) {
    return [
        'id' => null,
        'description' => $faker->unique()->randomElement($array = array('Capsule', 'Tablet', 'Powder', 'Liquid', 'Inhalant'))
    ];
});
