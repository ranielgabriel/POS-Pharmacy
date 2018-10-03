<?php

use Faker\Generator as Faker;

$factory->define(App\Customer::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name($gender = 'male'|'female'),
        'contact_number' => $faker->phoneNumber(),
        'address' => $faker->address(),
    ];
});
