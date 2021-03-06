<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Semester;
use Faker\Generator as Faker;

$factory->define(Semester::class, function (Faker $faker) {
    return [
        'organization_id' => 1,
        'semester_name' => 'Fall 2019',
        'start_date' => now()->subDay(),
        'end_date' => null,
        'active' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ];
});
