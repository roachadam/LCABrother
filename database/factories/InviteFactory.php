<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Invite;
use Faker\Generator as Faker;

$factory->define(Invite::class, function (Faker $faker) {
    return [
        'event_id' => function () {
            return factory(App\Event::class)->create()->id;
        },
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'guest_name' => $faker->name,
    ];
});
