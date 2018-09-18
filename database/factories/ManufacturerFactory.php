<?php

use Faker\Generator as Faker;

$factory->define(App\Manufacturer::class, function (Faker $faker) {
    return [
        'id' => $faker->randomElement($array = array('1','2','3')),
        'name' => $faker->randomElement($array = array('Unilab',
        'Uniliver',
        '3M Pharmaceuticals',
        'Ajanta Pharma',
        'Bargn Farmaceutici Phils Co',
        'Cipla',
        'Dabur',
        'Ego Pharmaceuticals',
        'F. Hoffmann–La Roche Ltd.',
        'Galderma Laboratories',
        'Hetero Drugs',
        'Interphil Laboratories',
        'JN-International Medical Corporation',
        'Kimia Farma',
        'Lupin Limited',
        'Mallinckrodt Pharmaceuticals',
        'Novo Nordisk',
        'Octapharma',
        'Pharma Medica',
        'Reckitt Benckiser',
        'Sanofi',
        'Teva Pharmaceuticals',
        'Unichem Laboratories',
        'Veloxis Pharmaceuticals',
        'Wallace Pharmaceuticals',
        'Yuhan Corporation',
        'Zandu Pharmaceuticals'))
    ];
});
