<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'organization_id' => function () {
            return factory(App\Organization::class)->create()->id;
        },
        'name' => $faker->catchPhrase,
        'date_of_event' => $faker->dateTime(),
        'num_invites' => $faker->randomDigitNotNull,
    ];
});
