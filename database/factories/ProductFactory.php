<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'id' => null,
        'brand_name' => $faker->unique()->randomElement($array = array
        ('Biogesic','Solmux','Altace', 'Amaryl', 'Dilantin', 'Effexor', 'Flonase' ,'Glucophage', 'Hytrin', 'Imitrex',
        'Lasix', 'Lopid', 'Mevacor', 'Micronase', 'Paxil', 'Prilosec', 'Procardia', 'Synthroid', 'Ultram', 'Wellbutrin',
        'Zantac', 'Zoloft')),
        'generic_name_id' => $faker->numberBetween($min = 1, $max = 21),
        'manufacturer_id' => $faker->numberBetween($min = 1, $max = 27),
        'drug_type_id' => $faker->numberBetween($min = 1, $max = 5),
        'purchase_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'special_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'walk_in_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'promo_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'distributor_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'status' => $faker->randomElement($array = array('Selling', 'In-stock'))
    ];
});
