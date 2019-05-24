<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Organization;
use Faker\Generator as Faker;

$factory->define(Organization::class, function (Faker $faker) {
    return [
        'name'=> $faker->company //'Bogan-Treutel' closer to an organization name
    ];
});
$factory->afterCreating(Organization::class, function ($Organization, $faker) {
    $Organization->createAdmin();
    $Organization->createBasicUser();
});
