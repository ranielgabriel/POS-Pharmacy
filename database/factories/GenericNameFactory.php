<?php

use Faker\Generator as Faker;

$factory->define(App\GenericName::class, function (Faker $faker) {
    return [
        'id' => null,
        'description' => $faker->unique()->randomElement($array = array 
        ('ramipril',
        'glimepiride',
        'zolpidem', 
        'lorazepam', 
        'verapamil SR', 
        'diltiazem ER' ,
        'sumatriptan', 
        'lovastatin', 
        'lisinopril',
        'amlodipine', 
        'fluoxetine', 
        'pravastatin', 
        'drospirenone/ethinyl estradiol', 
        'enalapril', 
        'albuterol', 
        'levothyroxine', 
        'risperidone', 
        'famotidine', 
        'phenytoin',
        'nifedipine', 
        'sertraline'))
    ];
});
