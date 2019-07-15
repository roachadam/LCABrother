<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\InvolvementLog;
use App\Involvement;
use App\User;
use App\Organization;
use Faker\Generator as Faker;

$factory->define(InvolvementLog::class, function (Faker $faker) {
    return [
        'organization_id' => function () {
            return factory(Organization::class)->create()->id;
        },
        'involvement_id' => function () {
            return factory(Involvement::class)->create()->id;
        },
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'date_of_event' => $faker->date(),
    ];
});
