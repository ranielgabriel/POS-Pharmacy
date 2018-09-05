<?php

use Faker\Generator as Faker;

$factory->define(App\DrugType::class, function (Faker $faker) {
    return [
        'id' => $faker->randomElement($array = array('1','2','3','4','5')),
        'description' => $faker->randomElement($array = array('Capsule', 'Tablet', 'Powder', 'Liquid', 'Inhalant'))
    ];
});
