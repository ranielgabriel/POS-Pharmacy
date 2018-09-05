<?php

use Faker\Generator as Faker;

$factory->define(App\DrugType::class, function (Faker $faker) {
    return [
        'description' => $faker->randomElement($array = array('Capsule', 'Tablet', 'Powder', 'Liquid', 'Inhalant'))
    ];
});
