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
$factory->state(App\Role::class, 'manage_members', function ($faker) {
    return [
        'name' => 'Member_Manager',
        'organization_id' => function()
        {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function()
        {
            return factory(App\Permission::class)->states('manage_members')->create()->id;
        }
    ];
});
$factory->state(App\Role::class, 'manage_involvement', function ($faker) {
    return [
        'name' => 'manage_involvement',
        'organization_id' => function()
        {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function()
        {
            return factory(App\Permission::class)->states('manage_involvement')->create()->id;
        }
    ];
});
$factory->state(App\Role::class, 'manage_service', function ($faker) {
    return [
        'name' => 'manage_service',
        'organization_id' => function()
        {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function()
        {
            return factory(App\Permission::class)->states('manage_service')->create()->id;
        }
    ];
});
$factory->state(App\Role::class, 'view_members', function ($faker) {
    return [
        'name' => 'view_members',
        'organization_id' => function()
        {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function()
        {
            return factory(App\Permission::class)->states('view_members')->create()->id;
        }
    ];
});
$factory->state(App\Role::class, 'view_service', function ($faker) {
    return [
        'name' => 'view_service',
        'organization_id' => function()
        {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function()
        {
            return factory(App\Permission::class)->states('view_service')->create()->id;
        }
    ];
});
$factory->state(App\Role::class, 'view_involvement', function ($faker) {
    return [
        'name' => 'view_involvement',
        'organization_id' => function()
        {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function()
        {
            return factory(App\Permission::class)->states('view_involvement')->create()->id;
        }
    ];
});
$factory->state(App\Role::class, 'log_service', function ($faker) {
    return [
        'name' => 'log_service',
        'organization_id' => function()
        {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function()
        {
            return factory(App\Permission::class)->states('view_involvement')->create()->id;
        }
    ];
});
