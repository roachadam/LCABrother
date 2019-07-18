<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\ServiceEvent;
use Faker\Generator as Faker;

$factory->define(ServiceEvent::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'date_of_event' => now(),
        'organization_id' => function () {
            return factory(App\Organization::class)->create()->id;
        },
    ];
});
