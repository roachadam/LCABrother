<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Attendance;
use Faker\Generator as Faker;
use App\AttendanceEvent;
use App\User;
use App\Organization;

$factory->define(Attendance::class, function (Faker $faker) {
    $organizationId = factory(Organization::class)->create()->id;

    return [
        'attendance_event_id' => function () use ($organizationId) {
            return factory(AttendanceEvent::class)->create(['organization_id' => $organizationId]);
        },
        'user_id' => function () use ($organizationId) {
            return factory(User::class)->create(['organization_id' => $organizationId]);
        },
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
