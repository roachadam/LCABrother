<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'organization_id' => function()
        {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function()
        {
            return factory(App\Permission::class)->create()->id;
        }
    ];
});

$factory->state(App\Role::class, 'admin', function ($faker) {
    return [
        'name' => 'admin',
        'organization_id' => function()
        {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function()
        {
            return factory(App\Permission::class)->states('admin')->create()->id;
        }
    ];
});
$factory->state(App\Role::class, 'basic_user', function ($faker) {
    return [
        'name' => 'admin',
        'organization_id' => function()
        {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function()
        {
            return factory(App\Permission::class)->states('basic_user')->create()->id;
        }
    ];
});
