<?php

use Faker\Generator as Faker;

$factory->define(App\Inventory::class, function (Faker $faker) {
    return [
        'supplier_id' => function () {
            try{
                return factory(App\Supplier::class)->create()->id;
            }catch(Exception $e){
                return factory(App\Supplier::class)->make()->id;
            }
        },
        'product_id' => function () {
            try{
                return factory(App\Product::class)->create()->id;
            }catch(Exception $e){
                return factory(App\Product::class)->make()->id;
            }
        },
        'quantity'=> $faker->numberBetween($min = 50, $max = 100),
        'sold' => $faker->numberBetween($min = 0, $max = 50),
        'expiration_date' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+2 years', $timezone = null),
        'batch_number' => function () {
            try{
                return factory(App\Batch::class)->create()->id;
            }catch(Exception $e){
                return factory(App\Batch::class)->make()->id;
            }
        },
        'delivery_date' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+1 week', $timezone = null)
    ];
});

