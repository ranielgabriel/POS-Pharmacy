<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'brand_name' => $faker->randomElement($array = array 
        ('Biogesic','Solmux','Altace', 'Amaryl', 'Dilantin', 'Effexor', 'Flonase' ,'Glucophage', 'Hytrin', 'Imitrex',
        'Lasix', 'Lopid', 'Mevacor', 'Micronase', 'Paxil', 'Prilosec', 'Procardia', 'Synthroid', 'Ultram', 'Wellbutrin',
        'Zantac', 'Zoloft')),
        'generic_name_id' => function () {
            return factory(App\GenericName::class)->create()->id;
        },
        'manufacturer_id' => function () {
            return factory(App\Manufacturer::class)->create()->id;
        },
        'drug_type_id' => function () {
            return factory(App\DrugType::class)->create()->id;
        },
        'market_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'special_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'walk_in_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'promo_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'distributor_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'status' => $faker->randomElement($array = array('Selling', 'In-stock'))
    ];
});
