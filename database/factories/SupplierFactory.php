<?php

use Faker\Generator as Faker;

$factory->define(App\Supplier::class, function (Faker $faker) {
    return [
        'id' => null,
        'name' => $faker->unique()->randomElement($array = array('Supplier 1', 'Supplier 2', 'Supplier 3', 'Supplier 4', 'Supplier 5')),
        'address' => $faker->address(),
        'email_address' => $faker->unique()->email(),
        'lto_number' => $faker->numberBetween($min = 1, $max = 100000),
        'expiration_date' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+2 years', $timezone = null),
        'contact_person' => $faker->name($gender = 'male'|'female'),
        'contact_number' => $faker->unique()->e164PhoneNumber()
    ];
});
