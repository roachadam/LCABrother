<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\User;
use App\Organization;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            'id' => 1,
            'role_id' => 1,
            'organization_id' => 1,
            'organization_verified' => 1,
            'name' => 'Jacob Drury',
            'phone' => '9857896665',
            'email' => 'jacobdrury75@gmail.com',
            'avatar' => 'user.jpg',
            'email_verified_at' => '2019-07-15 01:17:42',
            'password' => '$2y$10$AisLjz4rp03G6oU6qqDQ2.jCYkFLOIHQq4P0.6aXUdK0ABoEU1L/S',
        ]);
    }
}
