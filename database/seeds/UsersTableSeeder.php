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
        factory(App\User::class, 50)->create();
    }
}
