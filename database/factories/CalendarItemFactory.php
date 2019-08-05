<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\CalendarItem;
use Faker\Generator as Faker;
use App\Event;
use App\Organization;

$factory->define(CalendarItem::class, function (Faker $faker) {
    $organizationId = factory(Organization::class)->create()->id;

    return [
        'event_id' => function () use ($organizationId) {
            return factory(Event::class)->create(['organization_id' => $organizationId])->id;
        },
        'organization_id' => $organizationId,
        'name' => $faker->name(),
        'description' => $faker->sentence(6, true),
        'start_date' => now(),
        'end_date' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
