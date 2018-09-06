<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'id' => $faker->randomElement($array = array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22')),
        'brand_name' => $faker->randomElement($array = array
        ('Biogesic','Solmux','Altace', 'Amaryl', 'Dilantin', 'Effexor', 'Flonase' ,'Glucophage', 'Hytrin', 'Imitrex',
        'Lasix', 'Lopid', 'Mevacor', 'Micronase', 'Paxil', 'Prilosec', 'Procardia', 'Synthroid', 'Ultram', 'Wellbutrin',
        'Zantac', 'Zoloft')),
        'generic_name_id' => function () {
            try{
                return factory(App\GenericName::class)->create()->id;
            }catch(Exception $e){
                return factory(App\GenericName::class)->make()->id;
            }
        },
        'manufacturer_id' => function () {
            try{
                return factory(App\Manufacturer::class)->create()->id;
            }catch(Exception $e){
                return factory(App\Manufacturer::class)->make()->id;
            }
        },
        'drug_type_id' => function () {
            try{
                return factory(App\DrugType::class)->create()->id;
            }catch(Exception $e){
                return factory(App\DrugType::class)->make()->id;
            }
        },
        'purchase_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'special_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'walk_in_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'promo_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'distributor_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'status' => $faker->randomElement($array = array('Selling', 'In-stock'))
    ];
});
