<?php

use Faker\Generator as Faker;

$factory->define(App\Inventory::class, function (Faker $faker) {
    return [
        'supplier_id' => function () {
            return factory(App\Supplier::class)->create()->id;
        },
        'product_id' => function () {
            $product = factory(App\Product::class)->create()->id;
            return $product;
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

