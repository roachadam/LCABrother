<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\AttendanceEvent;
use Faker\Generator as Faker;
use App\Organization;
use App\Involvement;
use App\CalendarItem;

$factory->define(AttendanceEvent::class, function (Faker $faker) {
    $organizationId = factory(Organization::class)->create()->id;

    $data = [
        'organization_id' => $organizationId,
        'involvement_id' => function () use ($organizationId) {
            return factory(Involvement::class)->create(['organization_id' => $organizationId])->id;
        },
        'calendar_item_id' => function () use ($organizationId) {
            return factory(CalendarItem::class)->create(['organization_id' => $organizationId])->id;
        },
        'created_at' => now(),
        'updated_at' => now(),
    ];

    return $data;
});
