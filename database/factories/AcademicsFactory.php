<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Academics;
use Faker\Generator as Faker;

$factory->define(Academics::class, function (Faker $faker) {
    $standings = array("Good", "Probation", "Suspension");
    return [
        'id' => rand(1, 10),
        'organization_id' => 1,
        'user_id' => rand(0, 500),
        'name' => $faker->name,
        'Cumulative_GPA' => rand(1, 4.0),
        'Previous_Term_GPA' => rand(1, 4.0),
        'Current_Term_GPA' => rand(1, 4.0),
        'Previous_Academic_Standing' => $standings[array_rand($standings)],
        'Current_Academic_Standing' => $standings[array_rand($standings)],
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
