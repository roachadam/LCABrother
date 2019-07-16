<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\AcademicStandings;
use Faker\Generator as Faker;

$factory->define(AcademicStandings::class, function (Faker $faker) {
    return [
        'id' => rand(1, 10),
        'organization_id' => 1,
        'name' => 'Good',
        'Term_GPA_Min' => 2.5,
        'Cumulative_GPA_Min' => 2.5,
        'lowest' => 0,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
