<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Involvement;
use Faker\Generator as Faker;

$factory->define(Involvement::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'points' => $faker->randomDigitNotNull,
        'organization_id' => function()
        {
            return factory(App\Organization::class)->create()->id;
        },
    ];
});
