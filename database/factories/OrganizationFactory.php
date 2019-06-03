<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Involvement;
use App\Organization;
use Faker\Generator as Faker;

$factory->define(Organization::class, function (Faker $faker) {
    return [
        'name'=> $faker->company,
        'owner_id' => function()
        {
            return factory(App\User::class)->create()->id;
        }
    ];
});
$factory->afterCreating(Organization::class, function ($Organization, $faker) {
    $Organization->createAdmin();
    $Organization->createBasicUser();
    factory(Involvement::class)->create(['organization_id' => $Organization->id]);
});
