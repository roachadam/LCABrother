<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Goals;
use Faker\Generator as Faker;

$factory->define(Goals::class, function (Faker $faker) {
    return [
        'points_goal' => $faker->randomDigitNotNull,
        'study_goal' => $faker->randomDigitNotNull,
        'service_hours_goal' => $faker->randomDigitNotNull,
        'service_money_goal' => $faker->randomDigitNotNull,
    ];
});
