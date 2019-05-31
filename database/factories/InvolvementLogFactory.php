<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\InvolvementLog;
use Faker\Generator as Faker;

$factory->define(InvolvementLog::class, function (Faker $faker) {
    return [
        'organization_id' => function()
        {
            return factory(App\Organization::class)->create()->id;
        },
        'invovlement_id' => function()
        {
            return factor(App\Invovlement::class)->create()->id;
        },
        'user_id' => function(){
            return factor(App\User::class)->create()->id;
        },
        'date_of_event' => $faker->dateTime(),
    ];
});
