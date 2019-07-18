<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\ServiceEvent;
use Faker\Generator as Faker;

$factory->define(ServiceEvent::class, function (Faker $faker) {
    $names = collect(['Social', 'Pumpkin Bust', 'Pi', 'Brotherhood Event']);
    return [
        'name' => $names->random(),
        'date_of_event' => now(),
        'organization_id' => function () {
            return factory(App\Organization::class)->create()->id;
        },
    ];
});
