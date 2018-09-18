<?php

use Faker\Generator as Faker;

$factory->define(App\GenericName::class, function (Faker $faker) {
    return [
        'id' => $faker->randomElement($array = array('1','2','3','4','5')),
        'description' => $faker->randomElement($array = array 
        ('ramipril','glimepiride','zolpidem', 'lorazepam', 'verapamil SR', 'diltiazem ER' ,'sumatriptan', 'lovastatin', 'lisinopril',
        'amlodipine', 'fluoxetine', 'pravastatin', 'drospirenone/ethinyl estradiol', 'enalapril', 'albuterol', 'levothyroxine', 'risperidone', 'famotidine', 'phenytoin',
        'nifedipine', 'sertraline'))
    ];
});
