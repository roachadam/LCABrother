<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Permission;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'view_member_details' => $faker->boolean,
        'manage_member_details' => $faker->boolean,
        'log_service_event' => $faker->boolean,
        'view_all_service' => $faker->boolean,
        'view_all_involvement' => $faker->boolean,
        'manage_all_service' => $faker->boolean,
        'manage_all_involvement' => $faker->boolean,
    ];
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
    ];
});

$factory->state(App\Permission::class, 'basic_user', function ($faker) {
    return [
        'view_member_details' => false,
        'manage_member_details' => false,
        'log_service_event' => false,
        'view_all_service' => false,
        'view_all_involvement' => false,
        'manage_all_service' => false,
        'manage_all_involvement' => false,
    ];
});

$factory->state(App\Permission::class, 'manage_members', function ($faker) {
    return [
        'view_member_details' => false,
        'manage_member_details' => true,
        'log_service_event' => false,
        'view_all_service' => false,
        'view_all_involvement' => false,
        'manage_all_service' => false,
        'manage_all_involvement' => false,
    ];
});

$factory->state(App\Permission::class, 'manage_involvement', function ($faker) {
    return [
        'view_member_details' => false,
        'manage_member_details' => false,
        'log_service_event' => false,
        'view_all_service' => false,
        'view_all_involvement' => false,
        'manage_all_service' => false,
        'manage_all_involvement' => true,
    ];
});

$factory->state(App\Permission::class, 'manage_service', function ($faker) {
    return [
        'view_member_details' => false,
        'manage_member_details' => false,
        'log_service_event' => false,
        'view_all_service' => false,
        'view_all_involvement' => false,
        'manage_all_service' => true,
        'manage_all_involvement' => false,
    ];
});

$factory->state(App\Permission::class, 'view_members', function ($faker) {
    return [
        'view_member_details' => true,
        'manage_member_details' => false,
        'log_service_event' => false,
        'view_all_service' => false,
        'view_all_involvement' => false,
        'manage_all_service' => false,
        'manage_all_involvement' => false,
    ];
});

$factory->state(App\Permission::class, 'view_service', function ($faker) {
    return [
        'view_member_details' => false,
        'manage_member_details' => false,
        'log_service_event' => false,
        'view_all_service' => true,
        'view_all_involvement' => false,
        'manage_all_service' => false,
        'manage_all_involvement' => false,
    ];
});

$factory->state(App\Permission::class, 'view_involvement', function ($faker) {
    return [
        'view_member_details' => false,
        'manage_member_details' => false,
        'log_service_event' => false,
        'view_all_service' => false,
        'view_all_involvement' => false,
        'manage_all_service' => false,
        'manage_all_involvement' => true,
    ];
});

$factory->state(App\Permission::class, 'log_service', function ($faker) {
    return [
        'view_member_details' => false,
        'manage_member_details' => false,
        'log_service_event' => true,
        'view_all_service' => false,
        'view_all_involvement' => false,
        'manage_all_service' => false,
        'manage_all_involvement' => false,
    ];
});
