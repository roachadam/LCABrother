<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'organization_id' => function () {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function () {
            return factory(App\Permission::class)->create()->id;
        }
    ];
});

$factory->state(App\Role::class, 'admin', function ($faker) {
    return [
        'name' => 'admin',
        'organization_id' => function () {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function () {
            return factory(App\Permission::class)->states('admin')->create()->id;
        }
    ];
});

$factory->state(App\Role::class, 'basic_user', function ($faker) {
    return [
        'name' => 'admin',
        'organization_id' => function () {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function () {
            return factory(App\Permission::class)->states('basic_user')->create()->id;
        }
    ];
});

$factory->state(App\Role::class, 'member_viewer', function ($faker) {
    return [
        'name' => 'member_viewer',
        'organization_id' => function () {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function () {
            return factory(App\Permission::class)->states('member_viewer')->create()->id;
        }
    ];
});

$factory->state(App\Role::class, 'member_manager', function ($faker) {
    return [
        'name' => 'member_manager',
        'organization_id' => function () {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function () {
            return factory(App\Permission::class)->states('member_manager')->create()->id;
        }
    ];
});

$factory->state(App\Role::class, 'service_logger', function ($faker) {
    return [
        'name' => 'service_logger',
        'organization_id' => function () {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function () {
            return factory(App\Permission::class)->states('service_logger')->create()->id;
        }
    ];
});

$factory->state(App\Role::class, 'service_viewer', function ($faker) {
    return [
        'name' => 'service_viewer',
        'organization_id' => function () {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function () {
            return factory(App\Permission::class)->states('service_viewer')->create()->id;
        }
    ];
});


$factory->state(App\Role::class, 'involvement_viewer', function ($faker) {
    return [
        'name' => 'involvement_viewer',
        'organization_id' => function () {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function () {
            return factory(App\Permission::class)->states('involvement_viewer')->create()->id;
        }
    ];
});

$factory->state(App\Role::class, 'service_manager', function ($faker) {
    return [
        'name' => 'service_manager',
        'organization_id' => function () {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function () {
            return factory(App\Permission::class)->states('service_manager')->create()->id;
        }
    ];
});

$factory->state(App\Role::class, 'involvement_manager', function ($faker) {
    return [
        'name' => 'involvement_manager',
        'organization_id' => function () {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function () {
            return factory(App\Permission::class)->states('involvement_manager')->create()->id;
        }
    ];
});

$factory->state(App\Role::class, 'events_manager', function ($faker) {
    return [
        'name' => 'events_manager',
        'organization_id' => function () {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function () {
            return factory(App\Permission::class)->states('events_manager')->create()->id;
        }
    ];
});

$factory->state(App\Role::class, 'forum_manager', function ($faker) {
    return [
        'name' => 'forum_manager',
        'organization_id' => function () {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function () {
            return factory(App\Permission::class)->states('forum_manager')->create()->id;
        }
    ];
});

$factory->state(App\Role::class, 'alumni_manager', function ($faker) {
    return [
        'name' => 'alumni_manager',
        'organization_id' => function () {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function () {
            return factory(App\Permission::class)->states('alumni_manager')->create()->id;
        }
    ];
});

$factory->state(App\Role::class, 'survey_manager', function ($faker) {
    return [
        'name' => 'survey_manager',
        'organization_id' => function () {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function () {
            return factory(App\Permission::class)->states('survey_manager')->create()->id;
        }
    ];
});

$factory->state(App\Role::class, 'study_viewer', function ($faker) {
    return [
        'name' => 'study_viewer',
        'organization_id' => function () {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function () {
            return factory(App\Permission::class)->states('study_viewer')->create()->id;
        }
    ];
});

$factory->state(App\Role::class, 'academics_manager', function ($faker) {
    return [
        'name' => 'academics_manager',
        'organization_id' => function () {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function () {
            return factory(App\Permission::class)->states('academics_manager')->create()->id;
        }
    ];
});

$factory->state(App\Role::class, 'calendar_manager', function ($faker) {
    return [
        'name' => 'calendar_manager',
        'organization_id' => function () {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function () {
            return factory(App\Permission::class)->states('calendar_manager')->create()->id;
        }
    ];
});

$factory->state(App\Role::class, 'attendance_taker', function ($faker) {
    return [
        'name' => 'attendance_taker',
        'organization_id' => function () {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function () {
            return factory(App\Permission::class)->states('attendance_taker')->create()->id;
        }
    ];
});

$factory->state(App\Role::class, 'goals_manager', function ($faker) {
    return [
        'name' => 'goals_manager',
        'organization_id' => function () {
            return factory(App\Organization::class)->create()->id;
        },
        'permission_id' => function () {
            return factory(App\Permission::class)->states('goals_manager')->create()->id;
        }
    ];
});
