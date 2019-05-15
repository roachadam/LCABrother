<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Organization;
use Faker\Generator as Faker;

$factory->define(Organization::class, function (Faker $faker) {
    return [
        'name'=> $faker->company, //'Bogan-Treutel' closer to an organization name
        'owner_id' =>factory(App\User::class)   //https://www.neontsunami.com/posts/building-relations-with-laravel-model-factories
    ];
});
