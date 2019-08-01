<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Permission;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker) {
    return [];
});

$factory->state(App\Permission::class, 'admin', function ($faker) {
    return [
        'view_member_details' => true,
        'manage_member_details' => true,
        'log_service_event' => true,
        'view_all_service' => true,
        'view_all_involvement' => true,
        'manage_all_service' => true,
        'manage_all_involvement' => true,
        'manage_events' => true,
        'manage_forum' => true,
        'manage_alumni' => true,
        'manage_surveys' => true,
        'view_all_study' => true,
        'manage_all_study' => true,
        'manage_calendar' => true,
        'take_attendance' => true,
        'manage_goals' => true,
    ];
});

$factory->state(App\Permission::class, 'basic_user', function ($faker) {
    return [];
});

$factory->state(App\Permission::class, 'member_viewer', function ($faker) {
    return [
        'view_member_details' => true,
    ];
});

$factory->state(App\Permission::class, 'member_manager', function ($faker) {
    return [
        'view_member_details' => true,
        'manage_member_details' => true,
    ];
});

$factory->state(App\Permission::class, 'service_logger', function ($faker) {
    return [
        'log_service_event' => true,
        'view_all_service' => true,
    ];
});

$factory->state(App\Permission::class, 'service_viewer', function ($faker) {
    return [
        'view_all_service' => true,
    ];
});

$factory->state(App\Permission::class, 'involvement_viewer', function ($faker) {
    return [
        'view_all_involvement' => true,
    ];
});

$factory->state(App\Permission::class, 'service_manager', function ($faker) {
    return [
        'manage_all_service' => true,
    ];
});

$factory->state(App\Permission::class, 'involvement_manager', function ($faker) {
    return [
        'manage_all_involvement' => true,
        'view_all_involvement' => true,
    ];
});

$factory->state(App\Permission::class, 'events_manager', function ($faker) {
    return [
        'manage_events' => true,
    ];
});

$factory->state(App\Permission::class, 'forum_manager', function ($faker) {
    return [
        'manage_forum' => true,
    ];
});

$factory->state(App\Permission::class, 'alumni_manager', function ($faker) {
    return [
        'manage_alumni' => true,
    ];
});

$factory->state(App\Permission::class, 'survey_manager', function ($faker) {
    return [
        'manage_surveys' => true,
    ];
});

$factory->state(App\Permission::class, 'study_viewer', function ($faker) {
    return [
        'view_all_study' => true,
    ];
});

$factory->state(App\Permission::class, 'academics_manager', function ($faker) {
    return [
        'view_all_study' => true,
        'manage_all_study' => true,
    ];
});

$factory->state(App\Permission::class, 'calendar_manager', function ($faker) {
    return [
        'manage_calendar' => true,
    ];
});

$factory->state(App\Permission::class, 'attendance_taker', function ($faker) {
    return [
        'take_attendance' => true,
    ];
});

$factory->state(App\Permission::class, 'goals_manager', function ($faker) {
    return [
        'manage_goals' => true,
    ];
});
