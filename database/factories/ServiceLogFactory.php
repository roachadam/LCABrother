<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\ServiceLog;
use Faker\Generator as Faker;
use App\ServiceEvent;
use App\User;

$factory->define(ServiceLog::class, function (Faker $faker) {
    return [
        'organization_id' => function () {
            return factory(Organization::class)->create()->id;
        },
        'service_event_id' => function () {
            return factory(ServiceEvent::class)->create()->id;
        },
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'hours_served' => $faker->randomDigitNotNull,
        'money_donated' => $faker->randomDigitNotNull,
    ];
});
